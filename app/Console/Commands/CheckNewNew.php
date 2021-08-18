<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\XsDay;
use App\Models\XsDetail;
use App\Models\Predict;
use Carbon\Carbon;
use DB;
use Log;
use App\Enums\Location;

class CheckNewNew extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:CheckNewNew';

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
        Log::channel('log_batch')->info('start batch file check 99 day');
        $maxDate = Predict::where('type', '6868')->max('day');
        $startDate = empty($maxDate) ? "2021-01-01" : Carbon::parse($maxDate)->addDays(1)->format('Y-m-d');
        // $startDate = "2010-01-01";
        $now = Carbon::parse(Carbon::now()->addDays(1)->format('Y-m-d'));
        $totalMoney = 0;
        while (Carbon::parse($startDate) < $now) {
            Log::channel('log_batch')->info(Carbon::parse($startDate)->format('Y-m-d').'_check 99 day');
            $xsDays = XsDay::whereDate('day', '<=', Carbon::parse($startDate)->addDays(-1))
                ->whereDate('day', '>=', Carbon::parse($startDate)->addDays(-7))
                ->orderBy('day', 'DESC')
                ->with(['xsDetails'])
                ->get();
            $dataConvert = [];
            $dataTotal = [];
            foreach ($xsDays as $key => $xsDay) {
                foreach ($xsDay->xsDetails as $detail) {
                    if (isset($dataConvert[Carbon::parse($xsDay->day)->format('Y/m/d')][$detail->item])) {
                        $dataConvert[Carbon::parse($xsDay->day)->format('Y/m/d')][$detail->item]['value'] ++;
                    } else {
                        $dataConvert[Carbon::parse($xsDay->day)->format('Y/m/d')][$detail->item]['value'] = 1;
                    }
                    if (isset($dataTotal[$detail->item]['value'])) {
                        $dataTotal[$detail->item]['value']++;
                    } else {
                        $dataTotal[$detail->item]['value'] = 1;
                        $dataTotal[$detail->item]['key'] = $detail->item;
                    }
                    if ($detail->number_order == 0) {
                        $dataConvert[Carbon::parse($xsDay->day)->format('Y/m/d')][$detail->item]['special'] = 1;
                    }
                }
            }
            $dataTotal = collect($dataTotal)->sortByDesc('value');
            $detail = XsDay::whereDate('day', Carbon::parse($startDate))
                ->with(['xsDetails'])
                ->first();
            $xsDetail = $detail->xsDetails ?? [];
            $i = 0;
            $count = 0;
            foreach ($dataTotal as $key => $value) {
                if ($i >= 3) {
                    continue;
                }
                foreach ($xsDetail as $tmpDetail) {
                    if ($tmpDetail->item == $value['key']) {
                        $count++;
                    }
                }
                $i++;
            }
            if ($xsDetail) {
                $totalMoney += $count * 80000 * 10 - 3 * 10 * 21900;
            }
            $startDate = Carbon::parse($startDate)->addDays(1)->format('Y-m-d');
        }
        dd($totalMoney);
        Log::channel('log_batch')->info('complete_check 99 day');
    }
}
