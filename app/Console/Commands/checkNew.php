<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\XsDay;
use App\Models\XsDetail;
use App\Models\Predict;
use Carbon\Carbon;
use Log;

class checkNew extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checkNew';

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
        $startDate = "2010-01-01";
        $now = Carbon::parse(Carbon::now()->addDays(1)->format('Y-m-d'));
        $zero = 0;
        $one = 0;
        $two = 0;
        $max = 0;
        $totalMoney = 0;
        while (Carbon::parse($startDate) < $now) {
            Log::channel('log_batch')->info($startDate);
            $info = Predict::whereDate('day', Carbon::parse($startDate))->first();
            if ($info) {
                $info = json_decode($info->detail, true);
            } else {
                $info = [];
            }
            
            $detail = XsDay::whereDate('day', Carbon::parse($startDate))->with(['xsDetails'])->first();
            $xsDetail = $detail->xsDetails ?? [];
            $data = [];
            $countExist = 0;
            $total = 0;
            $tmpExist = [];
            $arrAll = [];
            foreach ($info as $key => $item) {
                $tmp = [];
                foreach ($item as $keyItem => $value) {
                    $exist = false;
                    if ($xsDetail) {
                        foreach ($xsDetail as $tmpDetail) {
                            if (intval($tmpDetail->item) == $keyItem) {
                                $exist = true;
                                $countExist++;
                                if ($tmpDetail->number_order == $key) {
                                    if (!isset($tmpExist[$keyItem])) {
                                        $tmpExist[$keyItem] = [
                                            'value' => 1,
                                            'key' => $keyItem,
                                        ];
                                    } else {
                                        $tmpExist[$keyItem]['value']++;
                                    }
                                }
                            }
                            $total++;
                        }
                    }
                    if (!isset($arrAll[$keyItem])) {
                        $arrAll[$keyItem] = [
                            'value' => 1,
                            'key' => $keyItem,
                        ];
                    } else {
                        $arrAll[$keyItem]['value']++;
                    }
                    $arrAll[$keyItem]['exist'] = $exist;
                    $tmp[] = [
                        'key' => $keyItem,
                        'value' => $value,
                        'exist' => $exist
                    ];
                }
                $tmp = collect($tmp)->sortByDesc('value')->toArray();
                $data[$key] = $tmp;
            }
            $tmpExist = !empty($tmpExist) ? collect($tmpExist)->sortByDesc('value')->toArray() : [];
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
            Log::channel('log_batch')->info($count);
            $totalMoney += (($count * 400) - 329);
            $startDate =  Carbon::parse($startDate)->addDays(1)->format('Y-m-d');
        }
        dd($totalMoney);
    }
}
