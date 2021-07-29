<?php

namespace App\Http\Controllers\Producer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\XsDay;
use App\Models\XsDetail;
use App\Models\Predict;
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
        $arrAll3 = collect($arrAll3)->sortByDesc('value')->toArray();

        $info = Predict::whereDate('day', Carbon::parse($day))->where('type', 5)->first();
        if ($info) {
            $info = json_decode($info->detail, true);
        } else {
            $info = [];
        }

        $detail = XsDay::whereDate('day', Carbon::parse($day))->with(['xsDetails'])->first();
        $xsDetail = $detail->xsDetails ?? [];
        $arrAll5 = [];
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
                if (!isset($arrAll5[$keyItem])) {
                    $arrAll5[$keyItem] = [
                        'value' => 1,
                        'key' => $keyItem,
                    ];
                } else {
                    $arrAll5[$keyItem]['value']++;
                }
                $arrAll5[$keyItem]['exist'] = $exist;
            }
            
        }
        $arrAll5 = collect($arrAll5)->sortByDesc('value')->toArray();

        $info = Predict::whereDate('day', Carbon::parse($day))->where('type', 7)->first();
        if ($info) {
            $info = json_decode($info->detail, true);
        } else {
            $info = [];
        }

        $detail = XsDay::whereDate('day', Carbon::parse($day))->with(['xsDetails'])->first();
        $xsDetail = $detail->xsDetails ?? [];
        $arrAll7 = [];
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
                if (!isset($arrAll7[$keyItem])) {
                    $arrAll7[$keyItem] = [
                        'value' => 1,
                        'key' => $keyItem,
                    ];
                } else {
                    $arrAll7[$keyItem]['value']++;
                }
                $arrAll7[$keyItem]['exist'] = $exist;
            }
            
        }
        $arrAll7 = collect($arrAll7)->sortByDesc('value')->toArray();
        return view('producer.dashboard.index', [
            'title' => 'ダッシュボード',
            'prev' => Carbon::parse($day)->addDays(-1)->format('Y-m-d'),
            'next' => Carbon::parse($day)->addDays(1)->format('Y-m-d'),
            'arrAll3' => $arrAll3,
            'arrAll5' => $arrAll5,
            'arrAll7' => $arrAll7,
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
