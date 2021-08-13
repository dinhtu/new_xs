<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\XsDay;
use App\Models\XsDetail;
use App\Models\Predict;
use App\Models\Result;
use App\Models\Point;
use Carbon\Carbon;
use Log;

class Result5Year extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:Result5Year';

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
        $maxDate = Result::where('type', 5)->max('day');
        $startDate = empty($maxDate) ? "2010-01-01" : Carbon::parse($maxDate)->addDays(1)->format('Y-m-d');
        //$startDate = "2010-01-01";
        $now = Carbon::parse(Carbon::now()->addDays(1)->format('Y-m-d'));
        $currentPoint = Point::first()->point ?? 10;
        while (Carbon::parse($startDate) < $now) {
            Log::channel('log_batch')->info('result:'. $startDate);
            $info = Predict::whereDate('day', Carbon::parse($startDate))->where('type', 5)->first();
            if ($info) {
                $info = json_decode($info->detail, true);
            } else {
                $startDate = Carbon::parse($startDate)->addDays(1)->format('Y-m-d');
                continue;
            }
            
            $detail = XsDay::whereDate('day', Carbon::parse($startDate))->with(['xsDetails'])->first();
            $xsDetail = $detail->xsDetails ?? [];
            $data = [];
            $countExist = 0;
            $total = 0;
            $tmpExist = [];
            $arrAll = [];
            foreach ($info as $keyItem => $value) {
                $tmp = [];
                $exist = false;
                if ($xsDetail) {
                    foreach ($xsDetail as $tmpDetail) {
                        if (intval($tmpDetail->item) == $keyItem) {
                            $exist = true;
                        }
                    }
                }
                if (!isset($arrAll[$keyItem])) {
                    $arrAll[$keyItem] = [
                        'value' => $value,
                        'key' => $keyItem,
                    ];
                }
                $arrAll[$keyItem]['exist'] = $exist;
            }
            foreach ($arrAll as $key => $value) {
                $exist = false;
                $countExist = 0;
                foreach ($xsDetail as $tmpDetail) {
                    if (intval($tmpDetail->item) == intval($value['key'])) {
                        $exist = true;
                        $countExist++;
                    }
                }
                if ($exist) {
                    if (!isset($arrAll[$key]['count'])) {
                        $arrAll[$key]['count'] = $countExist;
                    } else {
                        $arrAll[$key]['count'] += $countExist;
                    }
                }
            }
            $arrAll = collect($arrAll)->sortByDesc('value')->toArray();
            $i = 0;
            $count = 0;
            foreach ($arrAll as $key => $value) {
                if ($i >= 3) {
                    continue;
                }
                if ($xsDetail && $value['exist']) {
                    foreach ($xsDetail as $tmpDetail) {
                        if (intval($tmpDetail->item) == $value['key']) {
                            $count++;
                        }
                    }
                }
                $i++;
            }
            if ($info) {
                $result = new Result();
                $result->day = Carbon::parse($startDate);
                $result->total = $count;
                $result->type = 5;
                $result->save();
                Log::channel('log_batch')->info('save_result_complete_'.Carbon::parse($startDate)->format('Y-m-d'));
            }
            $startDate = Carbon::parse($startDate)->addDays(1)->format('Y-m-d');
        }
        Log::channel('log_batch')->info('result complete');
    }
}
