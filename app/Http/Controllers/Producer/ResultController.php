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
        $info = Result::whereYear('day', Carbon::parse($day)->format('Y'))->orderBy('day')->get();

        $dataInMonth = [];
        $dataInMonthMoney = [];
        $labelXMonth = [];
        $totalInMonth = 0;
        $color = [];
        foreach ($info as $key => $item) {
            $labelXMonth[Carbon::parse($item->day)->format('d')] = Carbon::parse($item->day)->format('d');
            $dataInMonth[Carbon::parse($item->day)->format('m')][] = $item->total;
            if (Carbon::parse($item->day)->format('m') == Carbon::parse($day)->format('m')) {
                $dataInMonthMoney[Carbon::parse($item->day)->format('d')] = $item->total*$item->point*80000 - $item->point * 21900*3;
                $totalInMonth += $item->total*$item->point*80000 - $item->point * 21900*3;
            }
            switch (Carbon::parse($item->day)->format('d')) {
                case '01':
                    $color[] = 'Black';
                    break;
                case '02':
                    $color[] = 'Red';
                    break;
                case '03':
                    $color[] = 'Lime';
                    break;
                case '04':
                    $color[] = 'Blue';
                    break;
                case '05':
                    $color[] = 'Yellow';
                    break;
                case '06':
                    $color[] = 'Cyan';
                    break;
                case '07':
                    $color[] = 'Fuchsia';
                    break;
                case '08':
                    $color[] = 'Maroon';
                    break;
                case '09':
                    $color[] = 'Olive';
                    break;
                case '10':
                    $color[] = 'Green';
                    break;
                case '11':
                    $color[] = 'Teal';
                    break;
                case '12':
                    $color[] = 'Navy';
                    break;      
            }
        }
        // dd($dataInMonth);

        $info = Result::whereDate('day', '<=', Carbon::now())
            ->whereDate('day', '>=', Carbon::now()->addDays(-15))->orderBy('day')->get();

        $dataHalfMonth = [];
        $dataHalfMonthMoney = [];
        $totalHalfMonth = 0;
        foreach ($info as $key => $item) {
            $dataHalfMonth[Carbon::parse($item->day)->format('d')] = $item->total;
            $dataHalfMonthMoney[Carbon::parse($item->day)->format('d')] = $item->total*$item->point*80000 - $item->point * 21900*3;
            $totalHalfMonth += $item->total*$item->point*80000 - $item->point * 21900*3;
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
            'labelXMonth' => $labelXMonth,
            'color' => $color,
        ]);
    }
}
