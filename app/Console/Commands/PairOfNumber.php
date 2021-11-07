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

class PairOfNumber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:PairOfNumber';

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
        // $startDate = empty($maxDate) ? "2021-01-01" : Carbon::parse($maxDate)->addDays(1)->format('Y-m-d');
        $startDate = "2020-01-01";
        // $now = Carbon::parse('2021-08-01');
        $now = Carbon::parse(Carbon::now()->format('Y-m-d'));
        $totalMoney = 0;

        $pairOfNumber = [];
        for ($i=0; $i < 100; $i++) { 
            $stt = sprintf('%02d', $i);
            $first = substr(trim($stt), 0, 1);
            $last = substr(trim($stt), 1, 1);
            if (isset($pairOfNumber[$first . '_' . $last]) || isset($pairOfNumber[$last . '_' . $first])) {
                continue;
            }
            if ($first == $last) {
                if ($first >= 5) {
                    continue;
                }
                $pairOfNumber[$first . '_' . $last] = [
                    $first . '' . $last,
                    $i + 55
                ];
            } else {
                $pairOfNumber[$first . '_' . $last] = [
                    $first . '' . $last,
                    $last . '' . $first,
                ];
            }
        }

        while (Carbon::parse($startDate) < $now) {
            Log::channel('log_batch')->info(Carbon::parse($startDate)->format('Y-m-d'));
            $xsDays = XsDay::whereDate('day', '<=', Carbon::parse($startDate)->addDays(-1))
            ->orderBy('day', 'DESC')
            ->with(['xsDetails'])
            ->limit(99)
            ->get();
            $pairOfNumberRes = [];
            $pairOfNumberCount = [];
            foreach ($xsDays as $xsDay) {
                foreach ($pairOfNumber as $itemPair) {
                    $flagExist = false;
                    $countTmp = 0;
                    foreach ($itemPair as $value) {
                        foreach ($xsDay->xsDetails as $xsDetail) {
                            if ($xsDetail->item == $value) {
                                $countTmp++;
                            }
                        }
                    }
                    if (isset($pairOfNumberCount[join('_', $itemPair)])) {
                        $pairOfNumberCount[join('_', $itemPair)]['count'] += $countTmp;
                    } else {
                        $pairOfNumberCount[join('_', $itemPair)] = [
                            'key' => $itemPair,
                            'count' => $countTmp
                        ];
                    }
                    if ($countTmp) {
                        $pairOfNumberRes[Carbon::parse($xsDay->day)->format('Y/m/d')][join('_', $itemPair)] = $countTmp;
                    }
                }
            }
            $xsDetailsDay = XsDetail::whereHas('xsDay', function($q) use ($startDate) {
                $q->whereDate('day', Carbon::parse($startDate));
            })->get();

            $pairOfNumberCount = collect($pairOfNumberCount)->sortByDesc('count')->toArray();
            $count = 0;
            $i = 0;
            foreach ($pairOfNumberCount as $key => $itemPairOfNumberCount) {
                if ($i > 2) {
                    continue;
                }
                foreach ($itemPairOfNumberCount['key'] as $key => $itemPair) {
                    foreach ($xsDetailsDay as $item) {
                        if ($item->item == $itemPair) {
                            $count++;
                        }
                    }
                }
                $i++;
            }
            if ($xsDetailsDay && $pairOfNumberCount) {
                $totalMoney += $count *800000 - 60*21900;
                Log::channel('log_batch')->info($startDate . '  :' . ($count *800000 - 60*21900));
            }
            $startDate = Carbon::parse($startDate)->addDays(1)->format('Y-m-d');
        }
        Log::channel('log_batch')->info($totalMoney);
    }
}
