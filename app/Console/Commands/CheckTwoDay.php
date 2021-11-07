<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\XsDay;
use App\Models\XsDetail;
use App\Models\Predict;
use Carbon\Carbon;
use DB;
use Log;
use App\Enums\Location;
use App\Models\Result;


class CheckTwoDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CheckTwoDay';

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
        Log::channel('log_batch')->info('start batch file');
        $currentDay = "2021-01-01";
        $now = Carbon::parse(Carbon::now()->addDays(1)->format('Y-m-d'));
        $money = 0;
        while (Carbon::parse($currentDay) < $now) {
            Log::channel('log_batch')->info($currentDay);
            $day = $request->day ?? Carbon::now()->format('Y-m-d');
            $twoDay = Predict::whereDate('day', Carbon::parse($currentDay))->where('type', 365)->first();
            if ($twoDay) {
                $twoDay = json_decode($twoDay->detail, true);
            } else {
                $twoDay = [];
            }
            $xsDays = XsDay::whereDate('day', Carbon::parse($currentDay))
                ->with([
                    'xsDetails'
                ])
                ->first();
            if (!$xsDays) {
                $currentDay = Carbon::parse($currentDay)->addDays(1)->format('Y-m-d');
                continue;
            }
            foreach ($twoDay as $key => $tmp) {
            
                $twoDay[$key]['exist'] = false;
                $twoDay[$key]['count'] = '';
                $count = 0;
                if ($xsDays) {
                    // $last1 = substr(trim($value['key']), 0, 1);
                    // $last2 = substr(trim($value['key']), 1, 1);
                    foreach ($xsDays->xsDetails as $value) {
                        if ($value->item == $tmp['key1'] || $value->item == $tmp['key2']) {
                            $count++;
                        }
                    }
                }
                if ($count) {
                    $twoDay[$key]['exist'] = true;
                    $twoDay[$key]['count'] = $count;
                }
            }
            
            $countTmp = 0;
            foreach ($twoDay as $key => $value) {
                if ($key>1) {
                    continue;
                }
                if ($value['count']) {
                    $countTmp += $value['count'];
                }
            }
            Log::channel('log_batch')->info(Carbon::parse($currentDay)->format('Y-m-d'). '. Count: ' . $countTmp . '. money: ' . ($countTmp*800000 - 60*21900));
            // Log::channel('log_batch')->info(Carbon::parse($currentDay)->format('Y-m-d'). '. Count: ' . $countTmp . '. money: ' . ($countTmp*800000 - 20*21900));
            $money += ($countTmp*800000 - 40*21900);
            // $money += ($countTmp*800000 - 20*21900);
            $currentDay = Carbon::parse($currentDay)->addDays(1)->format('Y-m-d');
        }
        Log::channel('log_batch')->info($money);
        Log::channel('log_batch')->info('result complete');
    }
}
