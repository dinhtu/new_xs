<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\XsDay;
use App\Models\XsDetail;
use App\Models\Predict;
use App\Models\Lottery;
use Carbon\Carbon;
use DB;
use Log;

class GetLottery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:GetLottery';

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
        Log::channel('log_batch')->info('start batch file');
        $maxDate = Lottery::max('day');
        $startDate = empty($maxDate) ? "2010-01-01" : Carbon::parse($maxDate)->addDays(1)->format('Y-m-d');
        //$startDate = "2020-04-02";
        $now = Carbon::parse(Carbon::now()->addDays(1)->format('Y-m-d'));
        while (Carbon::parse($startDate) < $now) {
            Log::channel('log_batch')->info(Carbon::parse($startDate)->format('Y-m-d'));
            $day = XsDay::whereDate('day', Carbon::parse($startDate)->addDays(-1))->with(['xsDetails'])->first();
            $dataAll = [];
            $xsDetails = $day->xsDetails ?? [];
            foreach ($xsDetails as $xsDetail) {
                $dayOld1 = XsDetail::where([
                    'number_order' => $xsDetail->number_order,
                ])
                ->with(['xsDay'])
                ->whereHas('xsDay', function($q) use ($startDate) {
                    $q->whereDate('day', Carbon::parse($startDate)->addDays(-2));
                })
                ->first();
                if (!$dayOld1) {
                    continue;
                }

                $dayOldOld = XsDetail::where([
                    'item' => $xsDetail->item,
                    'number_order' => $xsDetail->number_order,
                ])
                ->with(['xsDay'])
                ->whereHas('xsDay', function($q) use ($startDate) {
                    $q->whereDate('day', '<', Carbon::parse($startDate));
                })
                ->get();
                foreach ($dayOldOld as $dayTmp) {
                    $dayOldOld1 = XsDetail::where([
                        'number_order' => $xsDetail->number_order,
                        'item' => $dayOld1->item
                    ])
                    ->with(['xsDay'])
                    ->whereHas('xsDay', function($q) use ($dayTmp) {
                        $q->whereDate('day', Carbon::parse($dayTmp->xsDay->day)->addDays(-1));
                    })
                    ->exists();
                    if ($dayOldOld1) {
                        $dayNext = XsDay::whereDate('day', Carbon::parse($dayTmp->xsDay->day)->addDays(1))
                            ->with([
                                'xsDetailNext' => function($q) use ($xsDetail) {
                                    $q->where('number_order', $xsDetail->number_order);
                                }
                            ])
                            ->whereHas(
                                'xsDetailNext', function($q) use ($xsDetail) {
                                    $q->where('number_order', $xsDetail->number_order);
                                }
                            )
                            ->first();
                        if ($dayNext) {
                            if (!isset($dataAll[intval($dayNext->xsDetailNext->item)])) {
                                $dataAll[intval($dayNext->xsDetailNext->item)] = 1;
                            } else {
                                $dataAll[intval($dayNext->xsDetailNext->item)]++;
                            }
                        }
                    }
                }
            }
            if ($dataAll) {
                $lottery = new Lottery();
                $lottery->day = Carbon::parse($startDate);
                $lottery->detail = json_encode($dataAll);
                $lottery->save();
                Log::channel('log_batch')->info(Carbon::parse($startDate)->format('Y-m-d'). ' complete');
            }
            $startDate =  Carbon::parse($startDate)->addDays(1)->format('Y-m-d');
        }
        Log::channel('log_batch')->info('complete');
    }
}
