<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use Carbon\Carbon;
use App\Models\SpecialCal as SpecialCalModel;
use App\Models\XsDay;

class SpecialCal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SpecialCal';

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
        $maxDate = SpecialCalModel::max('day');
        $startDate = empty($maxDate) ? "2007-01-01" : Carbon::parse($maxDate)->addDays(1)->format('Y-m-d');
        $now = Carbon::parse(Carbon::now()->addDays(1)->format('Y-m-d'));
        
        while (Carbon::parse($startDate) < $now) {
            Log::channel('log_batch')->info(Carbon::parse($startDate)->format('Y-m-d'));
            $specicalDay = XsDay::with(['xsDetailSpecial'])->whereHas('xsDetailSpecial')->whereDate('day', Carbon::parse($startDate))->first();
            $specicalDayOld = XsDay::with(['xsDetailSpecial'])->whereHas('xsDetailSpecial')->whereDate('day', Carbon::parse($startDate)->addDays(-1))->first();
            if ($specicalDay && $specicalDayOld) {
                $specialCalModel = new SpecialCalModel();
                $specialCalModel->day = Carbon::parse($startDate);
                $specialCalModel->cal = $specicalDay->xsDetailSpecial->item - $specicalDayOld->xsDetailSpecial->item;
                if ($specicalDay->xsDetailSpecial->item - $specicalDayOld->xsDetailSpecial->item < 0) {
                    $specialCalModel->cal = -($specialCalModel->cal);
                }
                if ($specialCalModel->save()) {
                    Log::channel('log_batch')->info(Carbon::parse($startDate)->format('Y-m-d'). ' complete');
                }
            }
            $startDate =  Carbon::parse($startDate)->addDays(1)->format('Y-m-d');
        }
        Log::channel('log_batch')->info('complete');
    }
}
