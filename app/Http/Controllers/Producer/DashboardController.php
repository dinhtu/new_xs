<?php

namespace App\Http\Controllers\Producer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\XsDay;
use App\Models\XsDetail;
use App\Models\Predict;
use App\Models\Result;
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
        $info = Predict::whereDate('day', Carbon::parse($day))->where('type', 3)->first();
        if ($info) {
            $info = json_decode($info->detail, true);
        } else {
            $info = [];
        }

        $detail = XsDay::whereDate('day', Carbon::parse($day))->with(['xsDetails'])->first();
        $xsDetail = $detail->xsDetails ?? [];
        $arrAll3 = [];
        foreach ($info as $key => $item) {
            $tmp = [];
            foreach ($item as $keyItem => $value) {
                $exist = false;
                if ($xsDetail) {
                    foreach ($xsDetail as $tmpDetail) {
                        if (intval($tmpDetail->item) == $keyItem) {
                            $exist = true;
                        }
                    }
                }
                if (!isset($arrAll3[$keyItem])) {
                    $arrAll3[$keyItem] = [
                        'value' => 1,
                        'key' => $keyItem,
                    ];
                } else {
                    $arrAll3[$keyItem]['value']++;
                }
                $arrAll3[$keyItem]['exist'] = $exist;
            }
        }
        foreach ($arrAll3 as $key => $value) {
            $exist = false;
            $countExist = 0;
            foreach ($xsDetail as $tmpDetail) {
                if (intval($tmpDetail->item) == intval($value['key'])) {
                    $exist = true;
                    $countExist++;
                }
            }
            if ($exist) {
                if (!isset($arrAll3[$key]['count'])) {
                    $arrAll3[$key]['count'] = $countExist;
                } else {
                    $arrAll3[$key]['count'] += $countExist;
                }
            }
        }
        $arrAll3 = collect($arrAll3)->sortByDesc('value')->toArray();
        $info = Predict::whereDate('day', Carbon::parse($day))->where('type', 1)->first();
        if ($info) {
            $info = json_decode($info->detail, true);
        } else {
            $info = [];
        }

        $detail = XsDay::whereDate('day', Carbon::parse($day))->with(['xsDetails'])->first();
        $xsDetail = $detail->xsDetails ?? [];
        $arrAll1 = [];
        foreach ($info as $key => $item) {
            $tmp = [];
            foreach ($item as $keyItem => $value) {
                $exist = false;
                // $countExit = isset($arrAll1[$keyItem]['count']) ? $arrAll1[$keyItem]['count'] : 0;
                if ($xsDetail) {
                    foreach ($xsDetail as $tmpDetail) {
                        if (intval($tmpDetail->item) == $keyItem) {
                            $exist = true;
                        }
                    }
                }
                if (!isset($arrAll1[$keyItem])) {
                    $arrAll1[$keyItem] = [
                        'value' => 1,
                        'key' => $keyItem,
                        'count' => 1
                    ];
                } else {
                    $arrAll1[$keyItem]['value']++;
                }
                if ($exist) {
                    $arrAll1[$keyItem]['count']++;
                }
                $arrAll1[$keyItem]['exist'] = $exist;
            }
        }
        $arrAll1 = collect($arrAll1)->sortByDesc('value')->toArray();

        $info = Predict::whereDate('day', Carbon::parse($day))->where('type', 2)->first();
        if ($info) {
            $info = json_decode($info->detail, true);
        } else {
            $info = [];
        }

        $detail = XsDay::whereDate('day', Carbon::parse($day))->with(['xsDetails'])->first();
        $xsDetail = $detail->xsDetails ?? [];
        $arrAll2 = [];
        foreach ($info as $key => $item) {
            $tmp = [];
            foreach ($item as $keyItem => $value) {
                $exist = false;
                if ($xsDetail) {
                    foreach ($xsDetail as $tmpDetail) {
                        if (intval($tmpDetail->item) == $keyItem) {
                            $exist = true;
                        }
                    }
                }
                if (!isset($arrAll2[$keyItem])) {
                    $arrAll2[$keyItem] = [
                        'value' => 1,
                        'key' => $keyItem,
                    ];
                } else {
                    $arrAll2[$keyItem]['value']++;
                }
                $arrAll2[$keyItem]['exist'] = $exist;
            }
            
        }
        $arrAll2 = collect($arrAll2)->sortByDesc('value')->toArray();

        $day = $request->day ?? Carbon::now()->format('Y-m-d');
        $info = Result::whereMonth('day', Carbon::parse($day)->format('m'))
            ->whereYear('day', Carbon::parse($day)->format('Y'))->orderBy('day')->get();

        $pointInDay = 10;
        $dataInMonthMoney = [];
        $backGround = [];
        $totalInMonth = 0;
        foreach ($info as $key => $item) {
            if (isset($dataInMonthMoney[number_format($item->total*$pointInDay*80000 - $pointInDay * 21900*3)])) {
                $dataInMonthMoney[number_format($item->total*$pointInDay*80000 - $pointInDay * 21900*3)]++;
            } else {
                $dataInMonthMoney[number_format($item->total*$pointInDay*80000 - $pointInDay * 21900*3)] = 1;
            }
            $totalInMonth += $item->total*$pointInDay*80000 - $pointInDay * 21900*3;
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
            $backGround[number_format($item->total*$pointInDay*80000 - $pointInDay * 21900*3)] = $class;
        }
        $dataCompare = [];
        foreach ($dataInMonthMoney as $key => $value) {
            $dataCompare[$key . '(' . $value .')'] = $value;
        }

        return view('producer.dashboard.index', [
            'title' => 'ダッシュボード',
            'prev' => Carbon::parse($day)->addDays(-1)->format('Y-m-d'),
            'next' => Carbon::parse($day)->addDays(1)->format('Y-m-d'),
            'arrAll3' => $arrAll3,
            'arrAll1' => $arrAll1,
            'arrAll2' => $arrAll2,
            'backGround' => $backGround,
            'dataInMonthMoney' => $dataCompare,
            'totalInMonth' => $totalInMonth,
            'prevMonth' => Carbon::parse($day)->addMonths(-1)->format('Y-m'),
            'nextMonth' => Carbon::parse($day)->addMonths(1)->format('Y-m'),
        ]);
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
