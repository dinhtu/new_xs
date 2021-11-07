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

class Minus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:Minus';

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
        $startDate = "2021-10-01";
        // $now = Carbon::parse(Carbon::now()->format('Y-m-d'));
        $now = Carbon::parse(Carbon::now()->format('Y-m-d'));
        $totalMoney = 0;
        while (Carbon::parse($startDate) < $now) {
            $arr = [];
            for ($i=0; $i < 26; $i++) { 
                $xsDays1 = XsDay::whereDate('day', Carbon::parse($startDate)->addDays(-1))
                ->with([
                    'xsDetailOld' => function($q) use ($i) {
                        $q->where('number_order', $i);
                    }
                ])
                ->first();
                $xsDays2 = XsDay::whereDate('day', Carbon::parse($startDate)->addDays(-2))
                ->with([
                    'xsDetailOld' => function($q) use ($i) {
                        $q->where('number_order', $i);
                    }
                ])
                ->first();
                if (!$xsDays1 || !$xsDays2) {
                    $startDate = Carbon::parse($startDate)->addDays(1)->format('Y-m-d');
                    continue;
                }
                $last1 = substr(trim($xsDays1->xsDetailOld->item), 1, 1);
                $last2 = substr(trim($xsDays2->xsDetailOld->item), 1, 1);
                if (isset($arr[$last1.$last2]) || isset($arr[$last2.$last1])) {
                    if (isset($arr[$last1.$last2])) {
                        $arr[$last1.$last2]['value']++;
                    }
                    if (isset($arr[$last2.$last1])) {
                        $arr[$last2.$last1]['value']++;
                    }
                } else {
                    if (!isset($arr[$last1.$last2])) {
                        $arr[$last1.$last2]['value'] = 1;
                        $arr[$last1.$last2]['key'] = $last1.$last2;
                    }
                    if (!isset($arr[$last2.$last1])) {
                        $arr[$last2.$last1]['value'] = 1;
                        $arr[$last2.$last1]['key'] = $last2.$last1;
                    }
                }
            }
            $arr = collect($arr)->sortByDesc('value')->toArray();
            $arr = array_values($arr);

            $xsDays = XsDay::whereDate('day', Carbon::parse($startDate))
            ->with([
                'xsDetails'
            ])
            ->first();
            if (!$xsDays) {
                $startDate = Carbon::parse($startDate)->addDays(1)->format('Y-m-d');
                continue;
            }
            $last1 = substr(trim($arr[0]['key']), 0, 1);
            $last2 = substr(trim($arr[0]['key']), 1, 1);
            $count = 0;
            foreach ($xsDays->xsDetails as $key => $value) {
                if ($value->item == $last1.$last2 || $value->item == $last2.$last1) {
                    $count++;
                }
            }
            $totalMoney += ($count * 800000 - 20*21900);
            Log::channel('log_batch')->info($startDate . '  : ' . ($count * 800000 - 20*21900));
            $startDate = Carbon::parse($startDate)->addDays(1)->format('Y-m-d');
        }
        Log::channel('log_batch')->info($totalMoney);
    }
}
