<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\XsDay;
use App\Models\XsDetail;
use App\Models\Predict;
use App\Models\Lottery;
use Carbon\Carbon;
use DB;
use Log;

class LoteryResult extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:LoteryResult';

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
        $maxDate = Lottery::max('day');
        $startDate = empty($maxDate) ? "2021-07-01" : Carbon::parse($maxDate)->addDays(1)->format('Y-m-d');
        $startDate = "2021-07-01";
        $now = Carbon::parse(Carbon::now()->addDays(1)->format('Y-m-d'));
        $totalMoney = 0;
        while (Carbon::parse($startDate) < $now) {
            Log::channel('log_batch')->info(Carbon::parse($startDate)->format('Y-m-d'));
            $info = Lottery::whereDate('day', Carbon::parse($startDate))->first();
            if ($info) {
                $info = json_decode($info->detail, true);
            } else {
                $info = [];
            }
            
            $detail = XsDay::whereDate('day', Carbon::parse($startDate))->with(['xsDetails'])->first();
            $xsDetail = $detail->xsDetails ?? [];
            $dataLottery = [];
            
            foreach ($info as $key => $item) {
                $exist = false;
                if ($xsDetail) {
                    foreach ($xsDetail as $tmpDetail) {
                        if (intval($tmpDetail->item) == $key) {
                            $exist = true;
                        }
                    }
                }
                if (!isset($dataLottery[$key])) {
                    $dataLottery[$key] = [
                        'value' => 1,
                        'key' => $key,
                    ];
                } else {
                    $dataLottery[$key]['value']++;
                }
                $dataLottery[$key]['exist'] = $exist;
            }
            // dd($dataLottery);
            foreach ($dataLottery as $key => $value) {
                $exist = false;
                $countExist = 0;
                foreach ($xsDetail as $tmpDetail) {
                    if (intval($tmpDetail->item) == intval($key)) {
                        $exist = true;
                        $countExist++;
                    }
                }
                if ($exist) {
                    if (!isset($dataLottery[$key]['count'])) {
                        $dataLottery[$key]['count'] = $countExist;
                    } else {
                        $dataLottery[$key]['count'] += $countExist;
                    }
                } else {
                    if (!isset($dataLottery[$key]['count'])) {
                        $dataLottery[$key]['count'] = 0;
                    } 
                }
            }
            $countPoint = 0;
            $dataLottery = collect($dataLottery)->sortByDesc('value')->toArray();
            $i = 0;
            foreach ($dataLottery as $key => $value) {
                if ($i > 2) {
                    continue;
                }
                if ($value['exist']) {
                    $countPoint += $value['count'];
                }
                $i++;
            }
            $totalMoney += $countPoint*80000*10 - 30*21900;
            $startDate =  Carbon::parse($startDate)->addDays(1)->format('Y-m-d');
            Log::channel('log_batch')->info(Carbon::parse($startDate)->format('Y-m-d'). '   '. ($countPoint*80000*10 - 30*21900));
        }
        dd($totalMoney);
    }
}
