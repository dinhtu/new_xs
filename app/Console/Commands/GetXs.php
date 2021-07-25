<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler;
use Log;
use Sunra\PhpSimple\HtmlDomParser;
use Carbon\Carbon;
use App\Models\XsDay;
use App\Models\XsDetail;
use DB;

class GetXs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:GetXs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //01-01-2004
        ini_set('max_execution_time', 60000);
        set_time_limit(60000);
        ini_set('memory_limit', '512M');
        Log::channel('log_batch')->info('start batch file');
        $maxDate = XsDay::max('day');
        $startDate = empty($maxDate) ? Carbon::parse("01-01-2007") : Carbon::parse($maxDate)->addDays(1);
        $now = Carbon::parse(Carbon::now()->format('Y-m-d'));
        // $url = 'https://ketqua.net/xo-so.php?ngay=';
        $url = 'https://xskt.com.vn/xsmb/ngay-';
        while ($startDate < $now) {
            DB::beginTransaction();
            Log::channel('log_batch')->info($startDate->format('Y-m-d'));
            if (XsDay::whereDate('day', $startDate->format('Y-m-d'))->exists()) {
                $startDate = $startDate->addDays(1);
                continue;
            }
            $xsDay = new XsDay();
            $xsDay->day = $startDate;
            if (!$xsDay->save()) {
                return false;
            }

            $crawlerPage = new Crawler;
            $crawlerPage->addHTMLContent($this->getHtml($url . $startDate->format('d-m-Y')), 'UTF-8');
            // $crawlerPage->addHTMLContent($this->getHtml($url), 'UTF-8');
            $table = $crawlerPage->filter('table.result');

            $stt = 0;
            $table->each(function (Crawler $nodeTable) use (&$stt, $xsDay) {
                $nodeTable->filter('em')->each(function (Crawler $nodeDev) use (&$stt, $xsDay) {
                    if (is_numeric(trim($nodeDev->text()))) {
                        $xsDetail = new XsDetail();
                        $xsDetail->xs_day_id = $xsDay->id;
                        $xsDetail->origin = trim($nodeDev->text());
                        $xsDetail->item = substr(trim($nodeDev->text()), -2, 2);
                        $xsDetail->number_order = $stt;
                        if (!$xsDetail->save()) {
                            return false;
                        }
                    }
                    $stt++;
                });
                
                $nodeTable->filter('p')->each(function (Crawler $nodeDev) use (&$stt, $xsDay) {
                    $br = explode("<br>", $nodeDev->html());
                    foreach ($br as $itemBr) {
                        $space = explode(" ", $itemBr);
                        foreach ($space as $itemSpace) {
                            $xsDetail = new XsDetail();
                            $xsDetail->xs_day_id = $xsDay->id;
                            $xsDetail->origin = trim($itemSpace);
                            $xsDetail->item = substr(trim($itemSpace), -2, 2);
                            $xsDetail->number_order = $stt;
                            if (!$xsDetail->save()) {
                                return false;
                            }
                            $stt++;
                        }
                    }
                });
            });
            DB::commit();
            Log::channel('log_batch')->info($startDate->format('Y-m-d'). '-complete');
            $startDate = $startDate->addDays(1);
        }
        Log::channel('log_batch')->info('complete');
    }

    function getHtml($url, $post = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        if(!empty($post)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}