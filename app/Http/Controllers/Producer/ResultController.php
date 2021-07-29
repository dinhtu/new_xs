<?php

namespace App\Http\Controllers\Producer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\XsDay;
use App\Models\XsDetail;
use App\Models\Result;
use Carbon\Carbon;


class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $day = $request->day ?? Carbon::now()->format('Y-m-d');
        $info = Result::whereMonth('day', Carbon::parse($day)->format('m'))
            ->whereYear('day', Carbon::parse($day)->format('Y'))->orderBy('day')->get();

        $pointInDay = 10;
        $dataInMonth = [];
        $dataInMonthMoney = [];
        $totalInMonth = 0;
        foreach ($info as $key => $item) {
            $dataInMonth[Carbon::parse($item->day)->format('d')] = $item->total;
            $dataInMonthMoney[Carbon::parse($item->day)->format('d')] = $item->total*$pointInDay*80000 - $pointInDay * 21900*3;
            $totalInMonth += $item->total*$pointInDay*80000 - $pointInDay * 21900*3;
        }

        $info = Result::whereDate('day', '<=', Carbon::now())
            ->whereDate('day', '>=', Carbon::now()->addDays(-15))->orderBy('day')->get();

        $dataHalfMonth = [];
        $dataHalfMonthMoney = [];
        $totalHalfMonth = 0;
        foreach ($info as $key => $item) {
            $dataHalfMonth[Carbon::parse($item->day)->format('d')] = $item->total;
            $dataHalfMonthMoney[Carbon::parse($item->day)->format('d')] = $item->total*$pointInDay*80000 - $pointInDay * 21900*3;
            $totalHalfMonth += $item->total*$pointInDay*80000 - $pointInDay * 21900*3;
        }
        return view('producer.result.index', [
            'title' => 'ダッシュボード',
            'prev' => Carbon::parse($day)->addMonths(-1)->format('Y-m'),
            'next' => Carbon::parse($day)->addMonths(1)->format('Y-m'),
            'dataInMonth' => $dataInMonth,
            'totalInMonth' => $totalInMonth,
            'dataHalfMonth' => $dataHalfMonth,
            'totalHalfMonth' => $totalHalfMonth,
            'dataHalfMonthMoney' => $dataHalfMonthMoney,
            'dataInMonthMoney' => $dataInMonthMoney,
        ]);
    }
}
