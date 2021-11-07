<?php

namespace App\Http\Controllers\Producer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\XsDay;
use App\Models\XsDetail;
use App\Models\Predict;
use App\Models\Result;
use App\Models\Lottery;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $day = $request->day ?? Carbon::now()->format('Y-m-d');
        $detail = XsDay::whereDate('day', Carbon::parse($day))
            ->with(['xsDetails'])
            ->first();
        $xsDetail = $detail->xsDetails ?? [];
        $arr = [];
        foreach ($xsDetail as $key => $value) {
            if (isset($arr[$value->item])) {
                $arr[$value->item] ++;
            } else {
                $arr[$value->item] = 1;
            }
        }
        $xsDays = XsDay::whereDate('day', '<=', Carbon::parse($day)->addDays(-1))
            // ->whereDate('day', '>=', Carbon::parse($day)->addDays(-99))
            ->orderBy('day', 'DESC')
            ->with(['xsDetails'])
            ->limit(99)
            ->get();
        $dataConvert = [];
        $dataTotal = [];
        $dataSpecial = [];
        $countLess = 0;
        $countBigger = 0;
        foreach ($xsDays as $key => $xsDay) {
            foreach ($xsDay->xsDetails as $detail) {
                if (isset($dataConvert[Carbon::parse($xsDay->day)->format('Y/m/d')][$detail->item])) {
                    $dataConvert[Carbon::parse($xsDay->day)->format('Y/m/d')][$detail->item]['value'] ++;
                } else {
                    $dataConvert[Carbon::parse($xsDay->day)->format('Y/m/d')][$detail->item]['value'] = 1;
                }
                if (!$detail->number_order) {
                    $dataSpecial[] = [
                        "date" => Carbon::parse($xsDay->day)->format('Y/m/d'),
                        ($detail->item >= 50 ? 'bigger' : 'less') => $detail->item
                    ];
                    if ($detail->item >= 50) {
                        $countBigger++;
                    } else {
                        $countLess++;
                    }

                }
                if (isset($dataTotal[$detail->item]['value'])) {
                    if (!isset($dataTotal[$detail->item]['day'][Carbon::parse($xsDay->day)->format('Y/m/d')])) {
                        $dataTotal[$detail->item]['value']++;
                    }
                } else {
                    $dataTotal[$detail->item]['value'] = 1;
                    $dataTotal[$detail->item]['key'] = $detail->item;
                    $dataTotal[$detail->item]['day'][Carbon::parse($xsDay->day)->format('Y/m/d')] = Carbon::parse($xsDay->day)->format('Y/m/d');
                }
                if ($detail->number_order == 0) {
                    $dataConvert[Carbon::parse($xsDay->day)->format('Y/m/d')][$detail->item]['special'] = 1;
                }
            }
        }
        $dataTotal = collect($dataTotal)->sortByDesc('value');
        $xsDetailsDay = XsDetail::whereHas('xsDay', function($q) use ($day) {
            $q->whereDate('day', Carbon::parse($day));
        })->pluck('item', 'item');
        // dd($dataTotal);
        // $dataTotal = collect($dataTotal)->sortBy('key');
        // $dataTotal = $dataTotal->slice(0, 30);
        // dd($dataTotal->toArray());
        $xsDaySpecial = XsDay::whereDate('day', Carbon::parse($day)->addDays(-1))
            ->orderBy('day', 'DESC')
            ->with(['xsDetailNext' => function($q) {
                $q->where('number_order', 0);
            }])
            ->first();
            
        $totalSpecial = XsDay::whereDate('day', '<', Carbon::parse($day)->addDays(-1))
            ->whereDate('day', '>=', Carbon::parse($day)->addYears(-1))
            ->orderBy('day', 'DESC')
            ->whereHas('xsDetails', function($q) use ($xsDaySpecial) {
                $q->where('number_order', 0);
                $q->where('item', $xsDaySpecial->xsDetailNext->item ?? 100);
            })
            ->get();
        $countSpecial = [
            'less' => 0,
            'bigger' => 0,
        ];
        foreach ($totalSpecial as $item) {
            $xsDaySpecialNext = XsDay::whereDate('day', Carbon::parse($item->day)->addDays(1))
                // ->whereDate('day', '>=', Carbon::parse($day)->addDays(-99))
                ->orderBy('day', 'DESC')
                ->with(['xsDetailNext' => function($q) {
                    $q->where('number_order', 0);
                }])
                ->first();
                if (!$xsDaySpecialNext) {
                    continue;
                }
            if ($xsDaySpecialNext->xsDetailNext->item >= 50) {
                $countSpecial['bigger'] ++;
            } else {
                $countSpecial['less'] ++;
            }
        }
        $xsDaySpecialCurrent = XsDay::whereDate('day', Carbon::parse($day))
            // ->whereDate('day', '>=', Carbon::parse($day)->addDays(-99))
            ->orderBy('day', 'DESC')
            ->with(['xsDetailNext' => function($q) {
                $q->where('number_order', 0);
            }])
            ->first();
        $duplicate = [
            [
                'key' => ['02', '10'],
                'result' => ['89', '98']
            ],
            [
                'key' => ['24', '42'],
                'result' => ['27', '72']
            ],
            [
                'key' => ['78', '87'],
                'result' => ['48', '84']
            ],
            [
                'key' => ['48', '84'],
                'result' => ['05', '50']
            ],
            [
                'key' => ['36', '63'],
                'result' => ['38', '83']
            ],
            [
                'key' => ['38', '83'],
                'result' => ['67', '76']
            ],
            [
                'key' => ['45', '54'],
                'result' => ['56', '65']
            ],
            [
                'key' => ['47', '74'],
                'result' => ['79', '97']
            ],
            [
                'key' => ['23', '32'],
                'result' => ['34', '43']
            ],
            [
                'key' => ['14', '41'],
                'result' => ['18', '81']
            ],
            [
                'key' => ['57', '75'],
                'result' => ['58', '85']
            ],
            [
                'key' => ['69', '96'],
                'result' => ['17', '71']
            ],
            [
                'key' => ['05', '50'],
                'result' => ['26', '62']
            ],
            [
                'key' => ['02', '20'],
                'result' => ['12', '21']
            ],
            [
                'key' => ['00', '01'],
                'result' => ['10', '99']
            ],
            [
                'key' => ['11', '10'],
                'result' => ['01']
            ],
            [
                'key' => ['51', '59'],
                'result' => ['15']
            ],
            [
                'key' => ['97', '79'],
                'result' => ['37', '73']
            ],
            [
                'key' => ['66', '99'],
                'result' => ['66']
            ],
            [
                'key' => ['68', '69'],
                'result' => ['86']
            ],
            [
                'key' => ['06', '60'],
                'result' => ['06', '60']
            ],
            [
                'key' => ['05', '50'],
                'result' => ['05', '50']
            ],
        ];
        $arrCheck = [];
        $xsDayOld = XsDay::whereDate('day', Carbon::parse($day)->addDays(-1))
            ->orderBy('day', 'DESC')
            ->with(['xsDetails'])
            ->first();
        foreach ($duplicate as $item) {
            $flagExist = true;
            foreach ($item['key'] as $key) {
                $exist = false;
                if (!$xsDayOld) {
                    $flagExist = false;
                    continue;
                }
                foreach ($xsDayOld->xsDetails as $xsDetail) {
                    if ($xsDetail->item == $key) {
                        $exist = true;
                    }
                }
                if (!$exist) {
                    $flagExist = false;
                }
            }
            if ($flagExist) {
                foreach ($item['result'] as $key) {
                    $arrCheck[] = [
                        'key' => $key,
                        'exist' => isset($xsDetailsDay[$key]),
                        'event' => '('.join(",",$item['key']).')'
                    ];
                }
            }
        }
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
        $pairOfNumberCount = collect($pairOfNumberCount)->sortByDesc('count');
        $day = $request->day ?? Carbon::now()->format('Y-m-d');
        $twoDay = Predict::whereDate('day', Carbon::parse($day))->where('type', 268)->first();
        if ($twoDay) {
            $twoDay = json_decode($twoDay->detail, true);
        } else {
            $twoDay = [];
        }
        $xsDays = XsDay::whereDate('day', Carbon::parse($day))
            ->with([
                'xsDetails'
            ])
            ->first();
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
        
        return view('producer.dashboard.index', [
            'title' => 'Good luck',
            'prev' => Carbon::parse($day)->addDays(-1)->format('Y-m-d'),
            'next' => Carbon::parse($day)->addDays(1)->format('Y-m-d'),
            'dataAll' => $this->GetData($request, 68),
            'currentDate' =>  Carbon::parse($day)->format('Y/m/d'),
            'data100' => $this->GetData($request, 100),
            // 'data5Year' => $this->GetData($request, 2),
            // 'data3Year' => $this->GetData($request, 3),
            // 'data1Year' => $this->GetData($request, 4),
            'data6Month' => $this->GetData($request, 5),
            // 'dataOld' => $this->GetData($request, 6),
            'prevMonth' => Carbon::parse($day)->addMonths(-1)->format('Y-m'),
            'nextMonth' => Carbon::parse($day)->addMonths(1)->format('Y-m'),
            'arr' => $arr,
            'xsDetailsDay' => $xsDetailsDay,
            'pairOfNumberCount' => $pairOfNumberCount,
            'pairOfNumberRes' => $pairOfNumberRes,
            'dataConvert' => $dataConvert,
            'countBigger' => $countBigger,
            'countLess' => $countLess,
            'dataTotal' => $dataTotal,
            'twoDay' => $twoDay,
            'arrCheck' => $arrCheck,
            'dataSpecial' => $dataSpecial,
            'xsDaySpecialCurrent' => $xsDaySpecialCurrent,
            'countSpecial' => $countSpecial,
            'dualResult' => $this->getDual($day),
            'dualResultOld1' => $this->getDual(Carbon::parse($day)->addDays(-1)->format('Y-m-d')),
            'dualResultOld2' => $this->getDual(Carbon::parse($day)->addDays(-2)->format('Y-m-d')),

            // 'arrAll3' => $arrAll3,
            // 'arrAll5' => $arrAll5,
            // 'backGround' => $backGround,
            // 'dataInMonthMoney' => $dataCompare,
            // 'totalInMonth' => $totalInMonth,
            // 'dataInYear' => $dataInYear,
            // 'totalYear' => $totalYear,
            // // 'dataLottery' => $dataLottery,
            // 'prevYear' => Carbon::parse($day)->addYears(-1)->format('Y-m'),
            // 'nextYear' => Carbon::parse($day)->addYears(1)->format('Y-m'),
            // 'dataCompare5' => $dataCompare5,
            // 'backGround' => $backGround,
            // 'dataInMonthMoney' => $dataCompare5,
            // 'totalInMonth' => $totalInMonth,
        ]);
    }
    public function getDual($day) {
        $dualData = [];
        for ($i=0; $i <= 9; $i++) { 
            $dualData[$i.$i] = $i.$i;
        }
        $dualResult = [];
        //giai 7
        $detail = XsDay::whereDate('day', Carbon::parse($day)->addDays(-1))
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
        $detail = XsDay::whereDate('day', Carbon::parse($day)->addDays(-4))
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
        // dd($arrMute);
        foreach ($arrMute as $item) {
            $exists = XsDay::where(function($q) use ($day) {
                $q->orWhereDate('day', Carbon::parse($day)->addDays(-3));
                $q->orWhereDate('day', Carbon::parse($day)->addDays(-2));
                $q->orWhereDate('day', Carbon::parse($day)->addDays(-1));
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


        // $dataTogether = [
        //     '787' => 84,
        //     '484' => 64,
        //     '363' => 83,
        //     '010' => 60,
        //     '898' => 60,
        //     '242' => 72,
        // ];
        // $detail = XsDay::whereDate('day', Carbon::parse($day)->addDays(-1))
        //     ->with([
        //         'xsDetails'
        //     ])
        //     ->first();
        // $xsDetails = $detail->xsDetails ?? [];
        // foreach ($xsDetails as $xsDetail) {
        //     // dd($xsDetail->origin);
        //     if (strlen(trim($xsDetail->origin)) < 3) {
        //         continue;
        //     }
        //     $tmp = substr(trim($xsDetail->origin), strlen(trim($xsDetail->origin)) - 3, 3);
        //     if (isset($dataTogether[$tmp])) {
        //         $dualResult[$dataTogether[$tmp]] =  [
        //             'key' => $dataTogether[$tmp],
        //             'label' => 'together'
        //         ];
        //     }
        // }


        $xsDays = XsDay::where(function($q) use ($day) {
            $q->orWhereDate('day', Carbon::parse($day));
            $q->orWhereDate('day', Carbon::parse($day)->addDays(1));
            $q->orWhereDate('day', Carbon::parse($day)->addDays(2));
        })
            ->with(['xsDetails'])
            ->get();
        $xsDetail = $detail->xsDetails ?? [];
        foreach ($xsDays as $xsDay) {
            foreach ($xsDay->xsDetails as $xsDetail) {
                foreach ($dualResult as &$value) {
                    if ($xsDetail->item == $value['key']) {
                        $value['exist'] = 1;
                    }
                }
            }
        }
        return $dualResult;
    }
    public function GetData($request, $type) {
        $day = $request->day ?? Carbon::now()->format('Y-m-d');
        $info = Predict::whereDate('day', Carbon::parse($day))->where('type', $type)->first();
        if ($info) {
            $info = json_decode($info->detail, true);
        } else {
            $info = [];
        }
        $detail = XsDay::whereDate('day', Carbon::parse($day))->with(['xsDetails'])->first();
        $xsDetail = $detail->xsDetails ?? [];
        $detailOld = XsDay::whereDate('day', Carbon::parse($day)->addDays(-1))->with(['xsDetails'])->first();
        $xsDetailOld = $detailOld->xsDetails ?? [];
        $dataAll = [];
        foreach ($info as $keyItem => $value) {
            $tmp = [];
            $exist = false;
            if ($xsDetail) {
                foreach ($xsDetail as $tmpDetail) {
                    if ($tmpDetail->item == $keyItem) {
                        $exist = true;
                    }
                }
            }
            $existOld = false;
            if ($xsDetailOld) {
                foreach ($xsDetailOld as $tmpDetail) {
                    if ($tmpDetail->item == $keyItem) {
                        $existOld = true;
                    }
                }
            }
            $tmp = $value;
            $tmp['exist'] = $exist;
            $tmp['existOld'] = $existOld;
            $dataAll[$keyItem] = $tmp;
        }
        foreach ($dataAll as $key => $value) {
            $exist = false;
            $countExist = 0;
            foreach ($xsDetail as $tmpDetail) {
                if (intval($tmpDetail->item) == intval($value['key'])) {
                    $exist = true;
                    $countExist++;
                }
            }
            if ($exist) {
                if (!isset($dataAll[$key]['count'])) {
                    $dataAll[$key]['count'] = $countExist;
                } else {
                    $dataAll[$key]['count'] += $countExist;
                }
            }
        }

        $day = $request->day ?? Carbon::now()->format('Y-m-d');
        $info = Result::whereMonth('day', Carbon::parse($day)->format('m'))->where('type', $type)
            ->whereYear('day', Carbon::parse($day)->format('Y'))->orderBy('day')->get();

        $dataInMonthMoney = [];
        $backGround = [];
        $totalInMonth = 0;
        foreach ($info as $key => $item) {
            if (isset($dataInMonthMoney[number_format($item->total*$item->point*80000 - $item->point * 21900*3)])) {
                $dataInMonthMoney[number_format($item->total*$item->point*80000 - $item->point * 21900*3)]++;
            } else {
                $dataInMonthMoney[number_format($item->total*$item->point*80000 - $item->point * 21900*3)] = 1;
            }
            $totalInMonth += $item->total*$item->point*80000 - $item->point * 21900*3;
            $class = 'Gray';
            switch ($item->total) {
                case 0:
                    $class = 'Gray';
                    break;
                case 1:
                    $class = '#66FFFF';
                    break;
                case 2:
                    $class = '#00CC33';
                    break;
                case 3:
                    $class = '#006666';
                    break;
                default:
                    $class = 'Red';
            }
            $backGround[number_format($item->total*$item->point*80000 - $item->point * 21900*3)] = $class;
        }
        $dataCompare = [];
        foreach ($dataInMonthMoney as $key => $value) {
            $dataCompare[$key . '(' . $value .')'] = $value;
        }

        return [
            'data' => $dataAll,
            'dataInMonthMoney' => $dataInMonthMoney,
            'dataCompare' => $dataCompare,
            'totalInMonth' => $totalInMonth,
            'backGround' => $backGround,
        ];
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
