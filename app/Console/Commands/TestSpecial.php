<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Predict;
use App\Models\XsDay;
use Carbon\Carbon;
use DB;
use Log;
use App\Enums\Location;


class TestSpecial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:TestSpecial';

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
        $startDate = "2021-07-01";
        $now = Carbon::parse('2021-08-01');
        // $now = Carbon::parse(Carbon::now()->addDays(1)->format('Y-m-d'));
        $money = 0;
        while (Carbon::parse($startDate) < $now) {
            Log::channel('log_batch')->info(Carbon::parse($startDate)->format('Y-m-d').'_special');
            $xsDaySpecial = XsDay::whereDate('day', Carbon::parse($startDate)->addDays(-1))
                ->orderBy('day', 'DESC')
                ->with(['xsDetailNext' => function($q) {
                    $q->where('number_order', 0);
                }])
                ->first();

            $totalSpecial = XsDay::whereDate('day', '<', Carbon::parse($startDate)->addDays(-1))
                ->whereDate('day', '>=', Carbon::parse($startDate)->addMonths(-12))
                ->orderBy('day', 'DESC')
                ->whereHas('xsDetails', function($q) use ($xsDaySpecial) {
                    $q->where('number_order', 0);
                    $q->where('item', $xsDaySpecial->xsDetailNext->item ?? 100);
                })
                ->get();
            
            $countSpecial = [
                'less' => 0,
                'bigger' => 0,
            ];
            foreach ($totalSpecial as $item) {
                $xsDaySpecialNext = XsDay::whereDate('day', Carbon::parse($item->day)->addDays(1))
                    ->orderBy('day', 'DESC')
                    ->with(['xsDetailNext' => function($q) {
                        $q->where('number_order', 0);
                    }])
                    ->first();
                    if (!$xsDaySpecialNext) {
                        continue;
                    }
                if ($xsDaySpecialNext->xsDetailNext->item >= 50) {
                    $countSpecial['bigger'] ++;
                } else {
                    $countSpecial['less'] ++;
                }
            }
            $xsDaySpecialCurrent = XsDay::whereDate('day', Carbon::parse($startDate))
                ->orderBy('day', 'DESC')
                ->with(['xsDetailNext' => function($q) {
                    $q->where('number_order', 0);
                }])
                ->first();
            $flagSame = true;
            $flagTrue = true;
            if ($xsDaySpecialCurrent) {
                if ($countSpecial['less'] > $countSpecial['bigger']) {
                    $flagSame = false;
                    if ($xsDaySpecialCurrent->xsDetailNext->item >= 50) {
                        $flagTrue = false;
                    }
                }
                if ($countSpecial['less'] <= $countSpecial['bigger']) {
                    $flagSame = false;
                    if ($xsDaySpecialCurrent->xsDetailNext->item < 50) {
                        $flagTrue = false;
                    }
                }
            }
            if (!$flagSame) {
                $money += $flagTrue ? 840000 : -500000;
                Log::channel('log_batch')->info($flagTrue ? 840000 : -500000);
            }
            $startDate =  Carbon::parse($startDate)->addDays(1)->format('Y-m-d');
        }
        Log::channel('log_batch')->info($money);
    }
}
