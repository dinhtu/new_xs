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
        $info = Predict::whereDate('day', Carbon::parse($day))->where('type', 3)->first();
        if ($info) {
            $info = json_decode($info->detail, true);
        } else {
            $info = [];
        }

        $detail = XsDay::whereDate('day', Carbon::parse($day))->with(['xsDetails'])->first();
        $xsDetail = $detail->xsDetails ?? [];
        $detailOld = XsDay::whereDate('day', Carbon::parse($day)->addDays(-1))->with(['xsDetails'])->first();
        $xsDetailOld = $detailOld->xsDetails ?? [];
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
                $existOld = false;
                if ($xsDetailOld) {
                    foreach ($xsDetailOld as $tmpDetail) {
                        if (intval($tmpDetail->item) == $keyItem) {
                            $existOld = true;
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
                $arrAll3[$keyItem]['existOld'] = $existOld;
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
        // dd($arrAll3);

        $day = $request->day ?? Carbon::now()->format('Y-m-d');
        $info = Result::whereMonth('day', Carbon::parse($day)->format('m'))
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

        $day = $request->day ?? Carbon::now()->format('Y-m-d');
        $info = Result::whereDate('day', '>=', Carbon::parse($day)->addYears(-1)->format('Y-m-01'))
            ->whereDate('day', '<', Carbon::parse($day)->addMonths(1)->format('Y-m-01'))->orderBy('day')->get();

        $dataInYear = [];   
        $totalYear = 0;
        foreach ($info as $key => $item) {
            $price = $item->total*$item->point*80000 - $item->point * 21900*3;
            if (isset($dataInYear[Carbon::parse($item->day)->format('Y-m')])) {
                $dataInYear[Carbon::parse($item->day)->format('Y-m')] += $price;
            } else {
                $dataInYear[Carbon::parse($item->day)->format('Y-m')] = $price;
            }
            $totalYear += $price;
        }

        $day = $request->day ?? Carbon::now()->format('Y-m-d');
        $info = Lottery::whereDate('day', Carbon::parse($day))->first();
        if ($info) {
            $info = json_decode($info->detail, true);
        } else {
            $info = [];
        }

        $detail = XsDay::whereDate('day', Carbon::parse($day))->with(['xsDetails'])->first();
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
            }
        }

        $dataLottery = collect($dataLottery)->sortByDesc('value')->toArray();

        return view('producer.dashboard.index', [
            'title' => 'ダッシュボード',
            'prev' => Carbon::parse($day)->addDays(-1)->format('Y-m-d'),
            'next' => Carbon::parse($day)->addDays(1)->format('Y-m-d'),
            'arrAll3' => $arrAll3,
            'backGround' => $backGround,
            'dataInMonthMoney' => $dataCompare,
            'totalInMonth' => $totalInMonth,
            'dataInYear' => $dataInYear,
            'totalYear' => $totalYear,
            'dataLottery' => $dataLottery,
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
