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
        $info = Predict::whereDate('day', Carbon::parse($day))->first();
        if ($info) {
            $info = json_decode($info->detail, true);
        } else {
            $info = [];
        }

        $detail = XsDay::whereDate('day', Carbon::parse($day)->addDays(-1))->with(['xsDetails'])->first();
        $xsDetail = $detail->xsDetails ?? [];
        $data = [];
        foreach ($info as $key => $item) {
            $tmp = [];
            foreach ($item as $keyItem => $value) {
                $exist = false;
                if ($xsDetail) {
                    foreach ($xsDetail as $tmpDetail) {
                        if ($tmpDetail->number_order == $key && intval($tmpDetail->item) == $keyItem) {
                            $exist = true;
                        }
                    }
                }
                $tmp[] = [
                    'key' => $keyItem,
                    'value' => $value,
                    'exist' => $exist
                ];
            }
            $tmp = collect($tmp)->sortByDesc('value')->toArray();
            $data[$key] = $tmp;
        }
        return view('producer.dashboard.index', [
            'title' => 'ダッシュボード',
            'data' => $data
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
