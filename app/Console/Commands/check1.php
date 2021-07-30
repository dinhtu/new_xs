<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\XsDay;
use App\Models\XsDetail;
use App\Models\Predict;
use Carbon\Carbon;
use DB;
use Log;

class Check1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:check1';

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
        Log::channel('log_batch')->info('start batch file 1');
        $maxDate = Predict::where('type', 1)->max('day');
        $startDate = empty($maxDate) ? "2010-01-01" : Carbon::parse($maxDate)->addDays(1)->format('Y-m-d');
        //$startDate = "2020-04-02";
        $now = Carbon::parse(Carbon::now()->addDays(1)->format('Y-m-d'));
        
        while (Carbon::parse($startDate) < $now) {
            Log::channel('log_batch')->info(Carbon::parse($startDate)->format('Y-m-d').'-type-1');
            $day = XsDay::whereDate('day', Carbon::parse($startDate)->addDays(-1))->with(['xsDetails'])->first();
            $dataAll = [];
            foreach ($day->xsDetails as $xsDetail) {
                $dayOld = XsDetail::where([
                    'item' => $xsDetail->item,
                    'number_order' => $xsDetail->number_order,
                ])
                ->with(['xsDay'])
                ->whereHas('xsDay', function($q) use ($startDate) {
                    $q->whereDate('day', '<', Carbon::parse($startDate));
                })
                ->get();
                foreach ($dayOld as $dayTmp) {
                    $dayNext = XsDay::where(function($q) use ($dayTmp) {
                        for ($i = 1; $i <= 1; $i++) { 
                            $q->orWhereDate('day', Carbon::parse($dayTmp->xsDay->day)->addDays($i));
                        }
                    })
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
                        if (!isset($dataAll[$xsDetail->number_order][intval($dayNext->xsDetailNext->item)])) {
                            $dataAll[$xsDetail->number_order][intval($dayNext->xsDetailNext->item)] = 1;
                        } else {
                            $dataAll[$xsDetail->number_order][intval($dayNext->xsDetailNext->item)]++;
                        }
                    }
                }
            }
            if ($dataAll) {
                $predict = new Predict();
                $predict->day = Carbon::parse($startDate);
                $predict->type = 1;
                $predict->detail = json_encode($dataAll);
                $predict->save();
                Log::channel('log_batch')->info(Carbon::parse($startDate)->format('Y-m-d'). '-complete-type-1');
            }
            $startDate =  Carbon::parse($startDate)->addDays(1)->format('Y-m-d');
        }
        Log::channel('log_batch')->info('complete');
    }
}
