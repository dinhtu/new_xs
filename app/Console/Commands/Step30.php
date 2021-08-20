<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Predict;
use App\Models\XsDay;
use Carbon\Carbon;
use DB;
use Log;
use App\Enums\Location;

class Step30 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:Step30';

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
        Log::channel('log_batch')->info('start batch file check all');
        $maxDate = Predict::where('type', 100)->max('day');
        $startDate = empty($maxDate) ? "2021-01-01" : Carbon::parse($maxDate)->addDays(1)->format('Y-m-d');
        $now = Carbon::parse(Carbon::now()->addDays(1)->format('Y-m-d'));
        while (Carbon::parse($startDate) < $now) {
            Log::channel('log_batch')->info(Carbon::parse($startDate)->format('Y-m-d').'_ step 30');
            $type = Location::getValue(mb_strtolower(Carbon::parse($startDate)->format("l")));
            $day = XsDay::whereDate('day', '<', Carbon::parse($startDate))->with(['xsDetails'])
                ->where('type', $type)
                ->orderBy('day', 'DESC')
                ->first();
            
            $xsDetails = $day->xsDetails ?? [];
            $dataAll = [];
            foreach ($xsDetails as $xsDetail) {
                $dayOld = XsDay::whereDate('day', '<', Carbon::parse($day->day))
                    ->where('type', $type)
                    ->with([
                        'xsDetailOld' => function($q) use ($xsDetail) {
                            $q->where('item', $xsDetail->item);
                            $q->where('number_order', $xsDetail->number_order);
                        }
                    ])
                    ->whereHas('xsDetailOld', function($q) use ($xsDetail) {
                        $q->where('item', $xsDetail->item);
                        $q->where('number_order', $xsDetail->number_order);
                    })
                ->orderBy('day', 'DESC')
                ->limit(30)
                ->get();
                // dd($day->day);
                // dd($dayOld->toArray());
                foreach ($dayOld as $dayTmp) { 
                    $dayNext = XsDay::whereDate('day', '>', Carbon::parse($dayTmp->day))
                    ->whereDate('day', '<', Carbon::parse($startDate))
                    ->orderBy('day', 'ASC')
                    ->where('type', $type)
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
                $dataAll = $dataAll->slice(0, 30);
                $predict = new Predict();
                $predict->day = Carbon::parse($startDate);
                $predict->type = 100;
                $predict->detail = json_encode($dataAll);
                $predict->save();
                Log::channel('log_batch')->info(Carbon::parse($startDate)->format('Y-m-d'). '-complete step 30');
            }
            $startDate =  Carbon::parse($startDate)->addDays(1)->format('Y-m-d');
        }
    }
}
