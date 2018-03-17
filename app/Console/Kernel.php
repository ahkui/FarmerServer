<?php

namespace App\Console;

use App\Jobs\ConvertAddressToCoordinates;
use App\Jobs\ResetGoogleMapsApiCount;
use App\Jobs\QueueConvertGeo;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('convert:geo')->everyMinute();
        $schedule->command('location:generate')->daily();
        $schedule->job(new ResetGoogleMapsApiCount())->twiceDaily(0, 12);
        $schedule->job(new ConvertAddressToCoordinates())->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
