<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SpecialCal;
use App\Models\Special;
use App\Models\XsDay;
use Log;
use Carbon\Carbon;

class UpdateSpecial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:UpdateSpecial';

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
        $maxDate = Special::max('day');
        $startDate = empty($maxDate) ? "2010-01-01" : Carbon::parse($maxDate)->addDays(1)->format('Y-m-d');
        $now = Carbon::parse(Carbon::now()->addDays(1)->format('Y-m-d'));

        while (Carbon::parse($startDate) < $now) {
            Log::channel('log_batch')->info(Carbon::parse($startDate)->format('Y-m-d'));
            $data = [];
            $cal = SpecialCal::where('day', Carbon::parse($startDate))->first();
            if ($cal) {
                $specialCals = SpecialCal::where('cal', $cal->cal)->whereDate('day', '<', Carbon::parse($startDate))->get();
                foreach ($specialCals as $specialCal) {
                    $specicalDay = XsDay::with(['xsDetailSpecial'])->whereHas('xsDetailSpecial')->whereDate('day', Carbon::parse($specialCal->day))->first();
                    if ($specicalDay && $specicalDay->xsDetailSpecial) {
                        if (isset($data[$specicalDay->xsDetailSpecial->item])) {
                            $data[$specicalDay->xsDetailSpecial->item]++;
                        } else {
                            $data[$specicalDay->xsDetailSpecial->item] = 1;
                        }
                    }
                }
            }
            if ($data) {
                $special = new Special();
                $special->day = Carbon::parse($startDate);
                $special->detail = json_encode($data);
                if ($special->save()) {
                    Log::channel('log_batch')->info(Carbon::parse($startDate)->format('Y-m-d'). ' complete');
                }
            }
            $startDate = Carbon::parse($startDate)->addDays(1)->format('Y-m-d');
        }
        Log::channel('log_batch')->info('complete');
    }
}
