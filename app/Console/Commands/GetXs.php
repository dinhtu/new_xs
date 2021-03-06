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
use App\Enums\Location;

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
        $startDate = empty($maxDate) ? "2007-01-01" : Carbon::parse($maxDate)->addDays(1)->format('Y-m-d');
        // $startDate = '2007-01-01';
        $now = Carbon::parse(Carbon::now()->format('Y-m-d'));
        // $url = 'https://ketqua.net/xo-so.php?ngay=';
        $url = 'https://xskt.com.vn/xsmb/ngay-';
        while (Carbon::parse($startDate) <= $now) {
            DB::beginTransaction();
            try {
                Log::channel('log_batch')->info(Carbon::parse($startDate)->format('Y-m-d'));
                $xsDay = new XsDay();
                $xsDay->day = Carbon::parse($startDate);
                

                $crawlerPage = new Crawler;
                $tmp = Carbon::parse($startDate);
                $crawlerPage->addHTMLContent($this->getHtml($url . intval($tmp->format('d')) . '-' . intval($tmp->format('m')) . '-' .  $tmp->format('Y')), 'UTF-8');
                $table = $crawlerPage->filter('table.result');

                $stt = 0;
                $existDetail = false;
                $table->each(function (Crawler $nodeTable) use (&$xsDay) {
                    $nodeTable->filter('h3')->each(function (Crawler $nodeDev) use (&$xsDay) {
                        $start = strpos($nodeDev->text(), '(');
                        $end = strpos($nodeDev->text(), ')');
                        $text = substr($nodeDev->text(), $start + 1, $end - $start - 1);
                        $xsDay->type = Location::getValue(mb_strtolower($text));
                    });
                    
                });
                if (!$xsDay->save()) {
                    return false;
                }
                $table->each(function (Crawler $nodeTable) use (&$stt, $xsDay, &$existDetail) {
                    $nodeTable->filter('em')->each(function (Crawler $nodeDev) use (&$stt, $xsDay) {
                        $xsDetail = new XsDetail();
                        $xsDetail->xs_day_id = $xsDay->id;
                        $xsDetail->origin = trim($nodeDev->text());
                        $xsDetail->item = substr(trim($nodeDev->text()), -2, 2);
                        $xsDetail->number_order = $stt;
                        if (!$xsDetail->save()) {
                            return false;
                        }
                        $stt++;
                    });
                    
                    $nodeTable->filter('p')->each(function (Crawler $nodeDev) use (&$stt, $xsDay, &$existDetail) {
                        $br = explode("<br>", $nodeDev->html());
                        foreach ($br as $itemBr) {
                            $space = explode(" ", $itemBr);
                            foreach ($space as $itemSpace) {
                                $xsDetail = new XsDetail();
                                $xsDetail->xs_day_id = $xsDay->id;
                                $xsDetail->origin = trim($itemSpace);
                                $xsDetail->item = substr(trim($itemSpace), -2, 2);
                                $xsDetail->number_order = $stt;
                                $existDetail = true;
                                if (!$xsDetail->save()) {
                                    return false;
                                }
                                $stt++;
                            }
                        }
                    });
                });
                if ($existDetail) {
                    DB::commit();
                    Log::channel('log_batch')->info(Carbon::parse($startDate)->format('Y-m-d'). ' complete');
                } else {
                    DB::rollback();
                }
            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
            $startDate =  Carbon::parse($startDate)->addDays(1)->format('Y-m-d');
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