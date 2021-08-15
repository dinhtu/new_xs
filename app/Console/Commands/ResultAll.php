<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use Carbon\Carbon;
use App\Models\Result;
use App\Models\Point;
use App\Models\Predict;
use App\Models\XsDay;

class ResultAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ResultAll {type?}';

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
        $type = $this->argument('type');
        Log::channel('log_batch')->info('start batch file result '. $type);
        $maxDate = Result::where('type', $type)->max('day');
        $startDate = empty($maxDate) ? "2020-01-01" : Carbon::parse($maxDate)->addDays(1)->format('Y-m-d');
        //$startDate = "2010-01-01";
        $now = Carbon::parse(Carbon::now()->addDays(1)->format('Y-m-d'));
        $currentPoint = Point::first()->point ?? 10;
        while (Carbon::parse($startDate) < $now) {
            Log::channel('log_batch')->info('result:' . $type . '_'. $startDate);
            $info = Predict::whereDate('day', Carbon::parse($startDate))->where('type', $type)->first();
            if ($info) {
                $info = json_decode($info->detail, true);
            } else {
                $startDate = Carbon::parse($startDate)->addDays(1)->format('Y-m-d');
                continue;
            }
            $detail = XsDay::whereDate('day', Carbon::parse($startDate))->with(['xsDetails'])->first();
            $xsDetail = $detail->xsDetails ?? [];
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
                $tmp = $value;
                $tmp['exist'] = $exist;
                $tmp['count'] = 0;
                $dataAll[$keyItem] = $tmp;
            }
            $i = 0;
            $count = 0;
            foreach ($dataAll as $key => $value) {
                if ($i >= 3) {
                    continue;
                }
                foreach ($xsDetail as $tmpDetail) {
                    if (intval($tmpDetail->item) == intval($value['key'])) {
                        $count++;
                    }
                }
                $i++;
            }
            if ($info && $xsDetail) {
                $result = new Result();
                $result->day = Carbon::parse($startDate);
                $result->total = $count;
                $result->type = $type;
                $result->save();
                Log::channel('log_batch')->info('save_result_complete_'.Carbon::parse($startDate)->format('Y-m-d'));
            }
            $startDate = Carbon::parse($startDate)->addDays(1)->format('Y-m-d');
        }
        Log::channel('log_batch')->info('result complete');
    }
}
