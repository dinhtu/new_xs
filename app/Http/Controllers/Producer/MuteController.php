<?php

namespace App\Http\Controllers\Producer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\XsDay;
use App\Models\XsDetail;
use App\Models\Result;
use Carbon\Carbon;


class MuteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $day = $request->day ?? Carbon::now()->format('Y-m-d');
        $detail = XsDay::whereDate('day', Carbon::parse($day)->addDays(-1))
            ->with(['xsDetails'])
            ->first();
        $xsDetails = $detail->xsDetails ?? [];

        $arrMute = [];
        $arrDuplicate = [];
        foreach ($xsDetails as $xsDetail) {
            if (isset($arrDuplicate[$xsDetail->item])) {
                $arrDuplicate[$xsDetail->item]++;
            } else {
                $arrDuplicate[$xsDetail->item] = 1;
            }
        }
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
                $arrMute['last'][] = $i;
            }
            if (!$flagFirst) {
                $arrMute['first'][] = $i;
            }
        }
        $arrMuteInYear = [];
        $dataInYear = XsDay::whereDate('day', '<', Carbon::parse($day)->addDays(-1))
            ->whereDate('day', '>=', Carbon::parse($day)->addDays(-99))
            // ->whereDate('day', '>=', Carbon::parse($day)->addYears(-1))
            ->with(['xsDetails'])
            ->get();
        foreach ($dataInYear as $xsDay) {
            for ($i=0; $i <= 9; $i++) {
                $flagFirst = false;
                $flagEnd = false;
                foreach ($xsDay->xsDetails as $xsDetail) {
                    if (substr(trim($xsDetail->item), 0, 1) == $i) {
                        $flagFirst = true;
                    }
                    if (substr(trim($xsDetail->item), 1, 1) == $i) {
                        $flagEnd = true;
                    }
                }
                if (!$flagEnd) {
                    $arrMuteInYear['last'][$i][] =Carbon::parse($xsDay->day)->format('Y-m-d');
                }
                if (!$flagFirst) {
                    $arrMuteInYear['first'][$i][] =Carbon::parse($xsDay->day)->format('Y-m-d');
                }
            }
        }
        $duplicateAll = [];
        foreach ($dataInYear as $xsDay) {
            foreach ($xsDay->xsDetails as $xsDetail) {
                if (isset($duplicateAll[Carbon::parse($xsDay->day)->format('Y-m-d')][$xsDetail->item])) {
                    $duplicateAll[Carbon::parse($xsDay->day)->format('Y-m-d')][$xsDetail->item]++;
                } else {
                    $duplicateAll[Carbon::parse($xsDay->day)->format('Y-m-d')][$xsDetail->item] = 1;
                }
            }
        }
        $dataNext = [];
        foreach ($arrMute['first']?? [] as $keyFirst) {
            if (isset($arrMuteInYear['first'][$keyFirst])) {
                $days = $arrMuteInYear['first'][$keyFirst];
                foreach ($days as $key => $day) {
                    $dataMuteNexts = XsDay::where(function($q) use ($day) {
                        $q->orWhereDate('day', Carbon::parse($day)->addDays(1));
                        $q->orWhereDate('day', Carbon::parse($day)->addDays(2));
                        // $q->orWhereDate('day', Carbon::parse($day)->addDays(3));
                    })
                    ->with(['xsDetails'])
                    ->get();
                    foreach ($dataMuteNexts as $dataMuteNext) {
                        foreach ($dataMuteNext->xsDetails as $xsDetail) {
                            if (substr(trim($xsDetail->item), 0, 1) == $keyFirst) {
                                $dataNext[$keyFirst][$key][] = $xsDetail->item;
                            }
                        }
                    }
                }
            }
        }
        $arrResultFirst = [];
        foreach ($dataNext as $keyFirst => $valueFirst) {
            $valueFirst = array_values($valueFirst);
            $arrFirst = $valueFirst[0] ?? [];
            foreach ($arrFirst as $itemFirst) {
                $flag = true;
                for ($i=1; $i < count($valueFirst); $i++) {
                    $flagExist = false;
                    foreach ($valueFirst[$i] as $value) {
                        if ($value == $itemFirst) {
                            $flagExist = true;
                        }
                    }
                    if (!$flagExist) {
                        $flag = false;
                    }
                }
                if ($flag) {
                    $arrResultFirst[$itemFirst] = $itemFirst;
                }
            }
        }

        $dataNext = [];
        foreach ($arrMute['last']?? [] as $keyFirst) {
            if (isset($arrMuteInYear['last'][$keyFirst])) {
                $days = $arrMuteInYear['last'][$keyFirst];
                foreach ($days as $key => $day) {
                    $dataMuteNexts = XsDay::where(function($q) use ($day) {
                        $q->orWhereDate('day', Carbon::parse($day)->addDays(1));
                        $q->orWhereDate('day', Carbon::parse($day)->addDays(2));
                        // $q->orWhereDate('day', Carbon::parse($day)->addDays(3));
                    })
                    ->with(['xsDetails'])
                    ->get();
                    foreach ($dataMuteNexts as $dataMuteNext) {
                        foreach ($dataMuteNext->xsDetails as $xsDetail) {
                            if (substr(trim($xsDetail->item), 1, 1) == $i) {
                                $dataNext[$keyFirst][$key][] = $xsDetail->item;
                            }
                        }
                    }
                }
            }
        }
        $arrResultLast = [];
        foreach ($dataNext as $keyFirst => $valueFirst) {
            $valueFirst = array_values($valueFirst);
            $arrFirst = $valueFirst[0] ?? [];
            foreach ($arrFirst as $itemFirst) {
                $flag = true;
                for ($i=1; $i < count($valueFirst); $i++) {
                    $flagExist = false;
                    foreach ($valueFirst[$i] as $value) {
                        if ($value == $itemFirst) {
                            $flagExist = true;
                        }
                    }
                    if (!$flagExist) {
                        $flag = false;
                    }
                }
                if ($flag) {
                    $arrResultLast[$itemFirst] = $itemFirst;
                }
            }
        }

        $day = $request->day ?? Carbon::now()->format('Y-m-d');
        $xsDays = XsDay::where(function($q) use ($day) {
            // $q->orWhereDate('day', Carbon::parse($day)->addDays(1));
            // $q->orWhereDate('day', Carbon::parse($day)->addDays(2));
            $q->orWhereDate('day', Carbon::parse($day));
        })
            ->with(['xsDetails'])
            ->get();
        $resultFirst = [];
        foreach ($arrResultFirst as $key => $value) {
            $item = [
                'key' => $value,
                'exist' => false,
                'count' => 0
            ];
            $count = 0;
            foreach ($xsDays as $xsDay) {
                $xsDetails = $xsDay->xsDetails ?? [];
                foreach ($xsDetails as $xsDetail) {
                    if ($xsDetail->item == $value) {
                        $item['exist'] = true;
                        $count++;
                    }
                }
            }
            $item['count'] = $count;
            $resultFirst[$key] = $item;
        }
        $resultLast = [];
        foreach ($arrResultLast as $key => $value) {
            $item = [
                'key' => $value,
                'exist' => false
            ];
            foreach ($xsDays as $xsDay) {
                $xsDetails = $xsDay->xsDetails ?? [];
                foreach ($xsDetails as $xsDetail) {
                    if ($xsDetail->item == $value) {
                        $item['exist'] = true;
                    }
                }
            }
            $resultLast[$key] = $item;
        }
        $arrDayDuplicate = [];
        foreach ($arrDuplicate as $keyDuplicate => $itemDuplicate) {
            if ($itemDuplicate == 1) {
                continue;
            }
            foreach ($duplicateAll as $keyDuplicateAll => $valueDuplicateAll) {
                if (isset($valueDuplicateAll[$keyDuplicate]) && $valueDuplicateAll[$keyDuplicate] == $itemDuplicate) {
                // if (isset($valueDuplicateAll[$keyDuplicate]) && $valueDuplicateAll[$keyDuplicate] > 1) {
                    $arrDayDuplicate[$keyDuplicateAll][$keyDuplicate] = $valueDuplicateAll[$keyDuplicate];
                }
            }
        }
        $dataDupNext = [];
        foreach ($arrDayDuplicate as $day => $item) {
            foreach ($item as $key => $value) {
                $dataMuteNexts = XsDay::where(function($q) use ($day) {
                    $q->orWhereDate('day', Carbon::parse($day)->addDays(1));
                    // $q->orWhereDate('day', Carbon::parse($day)->addDays(2));
                    // $q->orWhereDate('day', Carbon::parse($day)->addDays(3));
                })
                ->with(['xsDetails'])
                ->get();
                foreach ($dataMuteNexts as $dataMuteNext) {
                    foreach ($dataMuteNext->xsDetails as $xsDetail) {
                        if (isset($dataDupNext[$key][$xsDetail->item]['value'])) {
                            $dataDupNext[$key][$xsDetail->item]['value']++;
                        } else {
                            $dataDupNext[$key][$xsDetail->item]['value'] = 1;
                        }
                    }
                }
            }
        }

        $arrResultDup = [];
        // foreach ($dataDupNext as $keyFirst => $valueFirst) {
        //     $valueFirst = array_values($valueFirst);
        //     $arrFirst = $valueFirst[0] ?? [];
        //     foreach ($arrFirst as $key => $itemFirst) {
        //         $flag = true;
        //         for ($i=1; $i < count($valueFirst); $i++) {
        //             $flagExist = false;
        //             foreach ($valueFirst[$i] as $key1 => $value) {
        //                 if ($key1 == $key) {
        //                     $flagExist = true;
        //                 }
        //             }
        //             if (!$flagExist) {
        //                 $flag = false;
        //             }
        //         }
        //         if ($flag) {
        //             $arrResultDup[$key] = $key;
        //         }
        //     }
        // }
        $resultDup = [];
        foreach ($dataDupNext as $key => $value) {
            foreach ($value as $key1 => $value1) {
                $item = [];
                $item['exist'] = false;
                $item['value'] = $value1['value'];
                $item['key'] = $key1;
                foreach ($xsDays as $xsDay) {
                    $xsDetails = $xsDay->xsDetails ?? [];
                    foreach ($xsDetails as $xsDetail) {
                        if ($xsDetail->item == $key1) {
                            $item['exist'] = true;
                        }
                    }
                }
                $resultDup[$key][] = $item;
            }
            // $resultDup[$key] = collect($value)->sortByDesc('value')->toArray();
        }
        $resultDup1 = [];
        foreach ($resultDup as $key => $value) {
            $resultDup1[$key] = collect($value)->sortByDesc('value')->toArray();
        }
        $day = $request->day ?? Carbon::now()->format('Y-m-d');

        return view('producer.mute.index', [
            'resultFirst' => $resultFirst,
            'resultLast' => $resultLast,
            'resultDup' => $resultDup1,
            'prev' => Carbon::parse($day)->addDays(-1)->format('Y-m-d'),
            'next' => Carbon::parse($day)->addDays(1)->format('Y-m-d'),
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
