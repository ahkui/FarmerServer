<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\GoogleMapsApi;
use Geocoder;

class ConvertAddressToCoordinates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $currentApiKey = config('geocoder.providers.Geocoder\Provider\Chain\Chain.Geocoder\Provider\GoogleMaps\GoogleMaps.1');
        if ($currentApiKey) {
            $items=[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,42,44,45,46,47,48,49,50];
            foreach ($items as $item) {
                $location = Geocoder::geocode('taiwan')->get()->first();
                if ($location) {
                    $apikey = GoogleMapsApi::whereApikey($currentApiKey)->first();
                    if($apikey)
                        $apikey->update(['used_count'=>$apikey->used_count+1]);
                }
            }
        }
    }
}
