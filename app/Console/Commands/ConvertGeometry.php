<?php

namespace App\Console\Commands;

use App\FarmPlace;
use Illuminate\Console\Command;

class ConvertGeometry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'convert:geo';

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
     * @return mixed
     */
    public function handle()
    {
        while ($item = FarmPlace::whereNull('location')->first()) {
            $item->location = ['type'=>'Point', 'coordinates'=>[$item->geometry['location']['lng'], $item->geometry['location']['lat']]];
            $item->save();
            dump(FarmPlace::whereNull('location')->count(), $item->id);
        }
    }
}
