<?php

namespace App\Console\Commands;

use App\ConvertedAddressData;
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
        // $data = ConvertedAddressData::get();
        // Storage::put('location.json', $data);
        if(FarmPlace::count() > 0){
            ini_set('memory_limit', '-1');
            Storage::put('location2.json', '[');
            $data = FarmPlace::skip(0)->take(1)->get()->first();
            Storage::append('location2.json', $data->toJson());
            $count = 1;
            $start = 0;
            $step = 10000;
            while($count > 0){
                dump($start);
                $data = FarmPlace::skip(1 + ($start * $step))->take($step)->get();
                $count = $data->count();
                if ($count > 0) 
                    Storage::append('location2.json', ','.substr($data->toJson(),1, -1));
                $start += 1;
            }
            Storage::append('location2.json', ']');
        }
    }
}
