<?php

namespace App\Console\Commands;

use App\FarmPlace;
use Illuminate\Console\Command;
use Storage;

class GenerateLocationJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Location JSON Data';

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
        if (FarmPlace::count() > 0) {
            ini_set('memory_limit', '-1');
            Storage::disk('public')->put('location.json', '[');
            $data = FarmPlace::select('geometry')->skip(0)->take(1)->get()->first();
            Storage::disk('public')->append('location.json', $data->toJson());
            $count = 1;
            $start = 0;
            $step = 10000;
            while ($count > 0) {
                dump($start);
                $data = FarmPlace::select('geometry')->skip(1 + ($start * $step))->take($step)->get();
                $count = $data->count();
                if ($count > 0) {
                    Storage::disk('public')->append('location.json', ','.substr($data->toJson(), 1, -1));
                }
                $start += 1;
            }
            Storage::disk('public')->append('location.json', ']');
        }
    }
}
