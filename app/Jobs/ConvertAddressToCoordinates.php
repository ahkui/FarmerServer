<?php

namespace App\Jobs;

use App\ConvertedAddressData;
use App\GoogleMapsApi;
use App\OriginalAddressData;
use Geocoder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        if (!empty(config('geocoder.providers.Geocoder\Provider\Chain\Chain.Geocoder\Provider\GoogleMaps\GoogleMaps.1'))) {
            $address = OriginalAddressData::whereNull('is_converted')->whereNull('is_fail')->whereNull('is_queue')->take(2500)->get();
            foreach ($address as $item) {
                $item->update(['is_queue'=>true]);
            }
            foreach ($address as $item) {
                $location = Geocoder::geocode($item->address)->get()->first();
                $apikey = GoogleMapsApi::whereApikey(config('geocoder.providers.Geocoder\Provider\Chain\Chain.Geocoder\Provider\GoogleMaps\GoogleMaps.1'))->first();
                $apikey->update(['used_count'=>$apikey->used_count + 1]);
                if ($location == null && $item->name) {
                    $location = Geocoder::geocode($item->name)->get()->first();
                    $apikey = GoogleMapsApi::whereApikey(config('geocoder.providers.Geocoder\Provider\Chain\Chain.Geocoder\Provider\GoogleMaps\GoogleMaps.1'))->first();
                    $apikey->update(['used_count'=>$apikey->used_count + 1]);
                }
                if ($location) {
                    $data = new ConvertedAddressData();
                    $temp = collect();
                    foreach ($location->getAdminLevels() as $key => $value) {
                        $temp->put($key, $value ? $value->getName() : '');
                    }
                    $data->levels = $temp;
                    $data->bounds = [];
                    $data->bounds->south = $location->getBounds()->getSouth();
                    $data->bounds->west = $location->getBounds()->getWest();
                    $data->bounds->north = $location->getBounds()->getNorth();
                    $data->bounds->east = $location->getBounds()->getEast();
                    $data->country = $location->getCountry() ? $location->getCountry()->getName() : '';
                    $data->address = $location->getFormattedAddress();
                    $data->latitude = $location->getCoordinates()->getLatitude();
                    $data->longitude = $location->getCoordinates()->getLongitude();
                    $data->location = ['type'=>'Point','coordinates'=>[$location->getCoordinates()->getLatitude(),$location->getCoordinates()->getLongitude()]];
                    $data->name = $item->name;
                    // $converted = ConvertedAddressData::firstOrCreate($data->toArray());
                    // $item->converted_address_data()->save($converted);
                    $item->converted_address_data()->save($data);
                    $item->update(['is_converted'=>true, 'is_fail'=>false]);
                } else {
                    $item->update(['is_fail'=>true, 'fail_count'=>$item->fail_count + 1]);
                }
            }
        }
        //*/
    }
}
