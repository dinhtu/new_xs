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

class TwoDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:TwoDay';

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
        $maxDate = Predict::where('type', 268)->max('day');
        $currentDay = empty($maxDate) ? "2021-1-01" : Carbon::parse($maxDate)->addDays(1)->format('Y-m-d');
        // $currentDay = "2021-11-06";
        $now = Carbon::parse(Carbon::now()->addDays(1)->format('Y-m-d'));

        
        while (Carbon::parse($currentDay) < $now) {
            Log::channel('log_batch')->info($currentDay);

            $dataRes = [];
            for ($i=0; $i < 27; $i++) { 
                $xsDays = XsDay::whereDate('day', '<', Carbon::parse($currentDay))
                ->with([
                    'xsDetailOld' => function($q) use ($i) {
                        $q->where('number_order', $i);
                    }
                ])
                ->orderBy('day', 'DESC')
                ->limit(2)
                ->get();
                // dd($xsDays->toArray());
                $last1 = substr(trim($xsDays[0]->xsDetailOld->item), 1, 1);
                $last2 = substr(trim($xsDays[1]->xsDetailOld->item), 1, 1);
                $so = $this->convert($last1, $last2);
                $xsDays100 = XsDay::whereDate('day', '<', Carbon::parse($currentDay))
                ->with([
                    'xsDetailOld' => function($q) use ($i) {
                        $q->where('number_order', $i);
                    }
                ])
                ->orderBy('day', 'DESC')
                ->limit(100)
                ->get();
                // dd($last1, $last2);
                $xsDays100 = array_values($xsDays100->reverse()->toArray());
                foreach ($xsDays100 as $key => $item) {
                    // dd($xsDays100[$key], $xsDays100[$key+1]);
                    // dd(isset($xsDays100[$key+1]));
                    if (!isset($xsDays100[$key + 1]) || !isset($xsDays100[$key + 2])) {
                        continue;
                    }
                    $lastTmp1 = substr(trim($xsDays100[$key]['xs_detail_old']['item']), 1, 1);
                    $lastTmp2 = substr(trim($xsDays100[$key + 1]['xs_detail_old']['item']), 1, 1);
                    $soTmp = $this->convert($lastTmp1, $lastTmp2);
                    if ($so[0] != $soTmp[0] && $so[0] != $soTmp[1]) {
                        continue;
                    }
                    $xsDayToDays = XsDay::whereDate('day', Carbon::parse($xsDays100[$key+2]['day']))
                    ->with([
                        'xsDetails'
                    ])
                    ->first();
                    $exist = false;
                    foreach ($xsDayToDays->xsDetails as $keyToDay => $xsDayToDay) {
                        if ($xsDayToDay->item == $so[0] || $xsDayToDay->item == $so[1]) {
                            $exist = true;
                        }
                    }

                    if (isset($dataRes[$i][$so[0]]) || isset($dataRes[$i][$so[1]])) {
                        if (isset($dataRes[$i][$so[0]])) {
                            $dataRes[$i][$so[0]]['total']++;
                            if ($exist) {
                                $dataRes[$i][$so[0]]['true']++;
                            }
                        }
                        if (isset($dataRes[$i][$so[1]])) {
                            $dataRes[$i][$so[1]]['total']++;
                            if ($exist) {
                                $dataRes[$i][$so[1]]['true']++;
                            }
                        }
                    } else {
                        if (!isset($dataRes[$i][$so[0]])) {
                            $dataRes[$i][$so[0]]['total'] = 1;
                            $dataRes[$i][$so[0]]['true'] = $exist ? 1 : 0;
                            $dataRes[$i][$so[0]]['key'] = $so[0];
                            $dataRes[$i][$so[0]]['key2'] = $so[1];
                            $dataRes[$i][$so[0]]['stt'] = $i;
                        }
                        if (!isset($dataRes[$i][$so[1]])) {
                            $dataRes[$i][$so[1]]['total'] = 1;
                            $dataRes[$i][$so[1]]['true'] = $exist ? 1 : 0;
                            $dataRes[$i][$so[1]]['key1'] = $so[0];
                            $dataRes[$i][$so[1]]['key2'] = $so[1];
                            $dataRes[$i][$so[1]]['stt'] = $i;
                        }
                    }

                    // dd($exist);
                    // dd($xsDays100[$key], $xsDays100[$key+1], $xsDays100[$key+2]);
                    // dd($lastTmp1, $lastTmp2);
                    // dd($item['xs_detail_old']);
                }
                // dd($xsDays100->toArray());
            }
            if ($dataRes) {
                $dataConvert = [];
                foreach ($dataRes as $key => $values) {
                    foreach ($values as $value) {
                        $dataConvert[$key] = $value;
                        $dataConvert[$key]['ratio'] = ($value['true']/$value['total'])*100;
                    }
                }
                $dataConvert = collect($dataConvert)->sortByDesc('ratio')->toArray();
                $dataConvert = array_values($dataConvert);
                $predict = new Predict();
                $predict->day = Carbon::parse($currentDay);
                $predict->type = 268;
                $predict->detail = json_encode($dataConvert);
                $predict->save();
                Log::channel('log_batch')->info(Carbon::parse($currentDay)->format('Y-m-d'). '-complete-type-365');
            }
            $currentDay = Carbon::parse($currentDay)->addDays(1)->format('Y-m-d');
        }
        Log::channel('log_batch')->info('result complete');
    }
    public function convert($st1, $st2) {
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
        if ($st1 == $st2 && $st2 >= 5) {
            $st1 = $st1 - 5;
            $st2 = $st2 - 5;
        }
        return isset($pairOfNumber[$st1 .'_'. $st2]) ? $pairOfNumber[$st1 .'_'. $st2] : $pairOfNumber[$st2 .'_'. $st1];
    }
}
