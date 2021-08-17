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
        $xsDays = XsDay::whereDate('day', '<', Carbon::parse($day))
            ->whereDate('day', '>=', Carbon::parse($day)->addDays(-99))
            ->orderBy('day', 'DESC')
            ->with(['xsDetails'])
            ->get();
        $dataConvert = [];
        foreach ($xsDays as $key => $xsDay) {
            foreach ($xsDay->xsDetails as $detail) {
                if (isset($dataConvert[$detail->item][Carbon::parse($xsDay->day)->format('Y/m/d')])) {
                    $dataConvert[$detail->item][Carbon::parse($xsDay->day)->format('Y/m/d')]['value'] ++;
                } else {
                    $dataConvert[$detail->item][Carbon::parse($xsDay->day)->format('Y/m/d')]['value'] = 1;
                }
                if (isset($dataTotal[$detail->item]['value'])) {
                    $dataTotal[$detail->item]['value']++;
                } else {
                    $dataTotal[$detail->item]['value'] = 1;
                    $dataTotal[$detail->item]['key'] = $detail->item;
                }
            }
        }
        // $dataConvert = collect($dataConvert)->sortBy('key');
        $arrSearch = [];
        foreach($dataConvert as $key => $item) {
            for ($i = 3; $i <= 7; $i++) {
                $searchItem = [];
                for ($j = 0; $j < $i; $j++) { 
                    if (isset($item[Carbon::parse($day)->addDays(-$j - 1)->format('Y/m/d')])) {
                        $searchItem[] = 1;
                    } else {
                        $searchItem[] = 0;
                    }
                }
                $arrSearch[$key][$i] = $searchItem;
            }
        }
        // dd($arrSearch);
        $arrSearchResult = [];
        foreach ($arrSearch as $key => $item) {
            $dataInSearch = $dataConvert[$key];
            // dd($item);
            
            foreach ($item as $keySearch => $itemSearch) {
                // dd($itemSearch);
                $test = [];
                for ($j = 1; $j <= 99; $j++) {
                    $tmp = [];
                    for ($i = 0; $i < $keySearch; $i++) {
                        if (isset($dataInSearch[Carbon::parse($day)->addDays(-($i + $j + 1))->format('Y/m/d')])) {
                            $tmp[] = 1;
                        } else {
                            $tmp[] = 0;
                        }
                    }
                    
                    $flagSame = true;
                    for ($i = 0; $i < $keySearch; $i++) {
                        if (isset($tmp[$i]) && isset($itemSearch[$i])) {
                            if ($tmp[$i] != $itemSearch[$i]) {
                                $flagSame = false;
                            }
                        } else {
                            $flagSame = false;
                        }
                    }
                    if ($flagSame) {
                        // dd(isset($dataInSearch[Carbon::parse($day)->addDays(-$j)->format('Y/m/d')]));
                        $arrSearchResult[$key][$keySearch][] = [
                            'val' => isset($dataInSearch[Carbon::parse($day)->addDays(-$j)->format('Y/m/d')]),
                            'date' => Carbon::parse($day)->addDays(-$j)->format('Y/m/d')
                        ];
                        $test[] = $tmp;
                    }
                    // dd($flagSame);
                }
                // dd($test);
                // if ($itemSearch)
            }
        }
        $arrResult = [];
        foreach ($arrSearchResult as $key => $itemSearch) {
            foreach ($itemSearch as $keySeach => $value) {
                foreach ($value as $item) {
                    if ($item['val']) {
                        if (isset($arrResult[$keySeach][$key]['value'])) {
                            $arrResult[$keySeach][$key]['value']++;
                        } else {
                            $arrResult[$keySeach][$key]['value'] = 1;
                        }
                    }
                }
            }
        }
        $arr = [];
        $day = $request->day ?? Carbon::now()->format('Y-m-d');
        $detail = XsDay::whereDate('day', Carbon::parse($day))
            ->with(['xsDetails'])
            ->first();
        $xsDetail = $detail->xsDetails ?? [];
        foreach ($arrResult as $key => $value) {
            foreach ($value as $key1 => &$value1) {
                # code...
                $value1['exist'] = false;
                $count = 0;
                foreach ($xsDetail as $tmpDetail) {
                    if ($tmpDetail->item == $key1) {
                        $exist = true;
                        $value1['exist'] = true;
                        $count++;
                    }
                }
                $value1['count'] = $count;
            }
            $arr[$key] = collect($value)->sortByDesc('value')->toArray();
        }
        // dd($arr);
        // dd($arrSearchResult);
        // dd($dataConvert);
        // // for ($i = 1; $i <= 99; $i++) { 
        // //     foreach ($arrSearch as $keySearch => $itemSearch) {
                
        // //     }
        // // }
        // // foreach($dataConvert as $key => $item) {

        // // }
        // dd($arr);
        // dd($dataConvert);

        return view('producer.result.index', [
            'title' => 'Good luck',
            'prev' => Carbon::parse($day)->addDays(-1)->format('Y-m-d'),
            'next' => Carbon::parse($day)->addDays(1)->format('Y-m-d'),
            'arr' => $arr,
            // 'totalInMonth' => $totalInMonth,
            // 'dataHalfMonth' => $dataHalfMonth,
            // 'totalHalfMonth' => $totalHalfMonth,
            // 'dataHalfMonthMoney' => $dataHalfMonthMoney,
            // 'dataInMonthMoney' => $dataInMonthMoney,
            // 'labelXMonth' => $labelXMonth,
            // 'color' => $color,
        ]);
    }
}
