<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\XsDay;
use App\Models\XsDetail;
use App\Models\Predict;
use Carbon\Carbon;
use DB;
use Log;

class CheckDual extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CheckDual';

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
        Log::channel('log_batch')->info('start batch file check dual');
        $maxDate = Predict::where('type', 51)->max('day');
        $startDate = empty($maxDate) ? "2021-01-01" : Carbon::parse($maxDate)->addDays(1)->format('Y-m-d');
        // $startDate = "2010-01-01";
        $now = Carbon::parse(Carbon::now()->addDays(1)->format('Y-m-d'));
        $total = 0;
        while (Carbon::parse($startDate) < $now) {
            Log::channel('log_batch')->info(Carbon::parse($startDate)->format('Y-m-d'));
            $dualResult = [];
            //giai 7
            $detail = XsDay::whereDate('day', Carbon::parse($startDate)->addDays(-1))
                ->with([
                    'xsDetails' => function($q) {
                        $q->whereIn('number_order', [23, 24, 25, 26]);
                    }
                ])
                ->first();
            $xsDetail = $detail->xsDetails ?? [];
            $dataSlip = [];
            foreach ($xsDetail as $value) {
                $dataSlip[] = [
                    substr(trim($value->item), 0, 1),
                    substr(trim($value->item), 1, 1),
                ];
            }
            for ($i=0; $i < count($dataSlip); $i++) {
                $first = $dataSlip[$i][0];
                $flag = false;
                for ($j=0; $j < count($dataSlip); $j++) { 
                    if ($i == $j) {
                        continue;
                    }
                    if ($first == $dataSlip[$j][1]) {
                        $flag = true;
                    }
                }
                if ($flag) {
                    $dualResult[$first.$first.'_solution'] = [
                        'key' => $first.$first,
                        'label' => 'solution 7'
                    ];
                }
            }
            //mute
            $detail = XsDay::whereDate('day', Carbon::parse($startDate)->addDays(-4))
                ->with([
                    'xsDetails'
                ])
                ->first();
            // dd($detail->toArray());
            $xsDetails = $detail->xsDetails ?? [];
            $arrMute = [];
            for ($i=0; $i <= 9; $i++) {
                $flagFirst = false;
                $flagEnd = false;
                foreach ($xsDetails as $xsDetail) {
                    if (substr(trim($xsDetail->item), 0, 1) == $i) {
                        $flagFirst = true;
                    }
                    if (substr(trim($xsDetail->item), 1, 1) == $i) {
                        $flagEnd = true;
                    }
                }
                if (!$flagEnd) {
                    $arrMute[$i.$i] =  [
                        'key' => $i.$i,
                        'label' => 'mute last'
                    ];
                }
                if (!$flagFirst) {
                    $arrMute[$i.$i] = [
                        'key' => $i.$i,
                        'label' => 'mute first'
                    ];
                }
            }
            foreach ($arrMute as $item) {
                $exists = XsDay::where(function($q) use ($startDate) {
                    $q->orWhereDate('day', Carbon::parse($startDate)->addDays(-3));
                    $q->orWhereDate('day', Carbon::parse($startDate)->addDays(-2));
                    $q->orWhereDate('day', Carbon::parse($startDate)->addDays(-1));
                })
                    ->whereHas('xsDetails', function($q) use ($item) {
                        $q->where('item', $item['key']);
                    })
                    ->exists();
                if ($exists) {
                    $dualResult[$item['key'].'_'.$item['label']] =  [
                        'key' => $item['key'],
                        'label' => $item['label']
                    ];
                }
            }

            $xsDays = XsDay::where(function($q) use ($startDate) {
                $q->orWhereDate('day', Carbon::parse($startDate));
                // $q->orWhereDate('day', Carbon::parse($startDate)->addDays(1));
                // $q->orWhereDate('day', Carbon::parse($startDate)->addDays(2));
            })
                ->orderBy('day')
                ->with(['xsDetails'])
                ->get();
            // dd($dualResult);
            $totalDay = 0;
            foreach ($dualResult as $value) {
                $exist = false;
                foreach ($xsDays as $xsDay) {
                    if ($exist) {
                        continue;
                    }
                    $count = 0;
                    foreach ($xsDay->xsDetails as $xsDetail) {
                        if ($xsDetail->item == $value['key']) { 
                            $count++;
                        }
                    }
                    $total += $count * 5 * 80000 - 5 * 21900;
                    $totalDay = $count * 5 * 80000 - 5 * 21900;
                    if ($count) {
                       $exist = true; 
                    }
                }
            }
            Log::channel('log_batch')->info('total = '. $totalDay);
            $startDate = Carbon::parse($startDate)->addDays(1)->format('Y-m-d');
        }
        dd($total);
    }
}
