<?php

namespace App\Console\Commands;

use App\ConvertedAddressData;
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
        $data = ConvertedAddressData::get();
        $data = $data->toJson();
        $data = $data->toJson();
        $result = Storage::put('location.json', $data);
        dd($result);
    }
}
