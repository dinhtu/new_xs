<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\XsDay;
use App\Models\XsDetail;
use App\Models\Predict;
use Carbon\Carbon;
use DB;
use Log;

class Check3Year extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:Check3Year';

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
        Log::channel('log_batch')->info('start batch file check 3 year');
        $maxDate = Predict::where('type', 3)->max('day');
        $startDate = empty($maxDate) ? "2020-01-01" : Carbon::parse($maxDate)->addDays(1)->format('Y-m-d');
        // $startDate = "2010-01-01";
        $now = Carbon::parse(Carbon::now()->addDays(1)->format('Y-m-d'));
        while (Carbon::parse($startDate) < $now) {
            Log::channel('log_batch')->info(Carbon::parse($startDate)->format('Y-m-d').'_check 3 year');
            $day = XsDay::whereDate('day', Carbon::parse($startDate)->addDays(-1))->with(['xsDetails'])->first();
            $xsDetails = $day->xsDetails ?? [];
            $dataAll = [];
            foreach ($xsDetails as $xsDetail) {
                $dayOld = XsDetail::where([
                    'item' => $xsDetail->item,
                    'number_order' => $xsDetail->number_order,
                ])
                ->with(['xsDay'])
                ->whereHas('xsDay', function($q) use ($startDate) {
                    $q->whereDate('day', '<', Carbon::parse($startDate)->addDays(-1));
                    $q->whereDate('day', '>=', Carbon::parse($startDate)->addYears(-3));
                })
                ->get();
                foreach ($dayOld as $dayTmp) {
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
                        if (!isset($dataAll[$dayNext->xsDetailNext->item])) {
                            $dataAll[$dayNext->xsDetailNext->item]['value'] = 1;
                            $dataAll[$dayNext->xsDetailNext->item]['key'] = $dayNext->xsDetailNext->item;
                        } else {
                            $dataAll[$dayNext->xsDetailNext->item]['value']++;
                        }
                    }
                }
            }
            if ($dataAll) {
                $dataAll = collect($dataAll)->sortByDesc('value');
                $dataAll = $dataAll->slice(0, 15);
                $predict = new Predict();
                $predict->day = Carbon::parse($startDate);
                $predict->type = 3;
                $predict->detail = json_encode($dataAll);
                $predict->save();
                Log::channel('log_batch')->info(Carbon::parse($startDate)->format('Y-m-d'). '-complete_check 3 year');
            }
            $startDate =  Carbon::parse($startDate)->addDays(1)->format('Y-m-d');
        }
        Log::channel('log_batch')->info('complete_check 3 year');
    }
}
