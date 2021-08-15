<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Predict;
use App\Models\XsDay;
use Carbon\Carbon;
use DB;
use Log;

class DayOld extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:DayOld';

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
        Log::channel('log_batch')->info('start batch file day old');
        $maxDate = Predict::where('type', 6)->max('day');
        $startDate = empty($maxDate) ? "2010-01-01" : Carbon::parse($maxDate)->addDays(1)->format('Y-m-d');
        // $startDate = "2010-01-01";
        $now = Carbon::parse(Carbon::now()->addDays(1)->format('Y-m-d'));
        while (Carbon::parse($startDate) < $now) {
            Log::channel('log_batch')->info(Carbon::parse($startDate)->format('Y-m-d').'_day old');

            $dayOlds = XsDay::whereMonth('day', Carbon::parse($startDate))
                ->whereDay('day', Carbon::parse($startDate))
                ->whereDate('day', '<', Carbon::parse($startDate)->addDays(-1))
                ->with(['xsDetails'])
                ->get();
            $dataAll = [];
            foreach ($dayOlds as $day) {
                foreach ($day->xsDetails as $value) {
                    if (!isset($dataAll[$value->item])) {
                        $dataAll[$value->item]['value'] = 1;
                        $dataAll[$value->item]['key'] = $value->item;
                    } else {
                        $dataAll[$value->item]['value']++;
                    }
                }
            }
            if ($dataAll) {
                $dataAll = collect($dataAll)->sortByDesc('value');
                $dataAll = $dataAll->slice(0, 15);
                $predict = new Predict();
                $predict->day = Carbon::parse($startDate);
                $predict->type = 6;
                $predict->detail = json_encode($dataAll);
                $predict->save();
                Log::channel('log_batch')->info(Carbon::parse($startDate)->format('Y-m-d'). '-complete_day old');
            }
            $startDate =  Carbon::parse($startDate)->addDays(1)->format('Y-m-d');
        }
    }
}
