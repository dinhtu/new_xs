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

class Check99Day extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:Check99Day';

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
        $maxDate = Predict::where('type', 68)->max('day');
        $startDate = empty($maxDate) ? "2020-01-01" : Carbon::parse($maxDate)->addDays(1)->format('Y-m-d');
        // $startDate = "2010-01-01";
        $now = Carbon::parse(Carbon::now()->addDays(1)->format('Y-m-d'));
        while (Carbon::parse($startDate) < $now) {
            Log::channel('log_batch')->info(Carbon::parse($startDate)->format('Y-m-d').'_check 99 day');
            $type = Location::getValue(mb_strtolower(Carbon::parse($startDate)->format("l")));
            $xsDays = XsDay::whereDate('day', '<', Carbon::parse($startDate))
                ->where('type', $type)
                // ->whereDate('day', '>=', Carbon::parse($startDate)->addDays(-99))
                ->orderBy('day', 'DESC')
                ->with(['xsDetails'])
                ->limit(99)
                ->get();
            $dataTotal = [];
            $dataConvert = [];
            foreach ($xsDays as $key => $xsDay) {
                foreach ($xsDay->xsDetails as $detail) {
                    if (isset($dataConvert[$detail->item])) {
                        $dataConvert[$detail->item]['value']++;
                    } else {
                        $dataConvert[$detail->item]['value'] = 1;
                        $dataConvert[$detail->item]['key'] = $detail->item;
                    }
                }
            }

            if ($dataConvert) {
                $dataConvert = collect($dataConvert)->sortByDesc('value');
                $dataConvert = $dataConvert->slice(0, 30);
                $predict = new Predict();
                $predict->day = Carbon::parse($startDate);
                $predict->type = 68;
                $predict->detail = json_encode($dataConvert);
                $predict->save();
                Log::channel('log_batch')->info(Carbon::parse($startDate)->format('Y-m-d'). '-complete_check 99 day');
            }
            $startDate = Carbon::parse($startDate)->addDays(1)->format('Y-m-d');
        }
        Log::channel('log_batch')->info('complete_check 99 day');
    }
}
