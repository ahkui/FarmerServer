<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\GoogleMapsApi;
use App\OriginalAddressData;
use App\ConvertedAddressData;
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
        if (config('geocoder.providers.Geocoder\Provider\Chain\Chain.Geocoder\Provider\GoogleMaps\GoogleMaps.1')) {
            $address = OriginalAddressData::whereIsConverted(false)->whereIsFail(false)->whereIsQueue(false)->take(2500)->get();
            foreach ($address as $item) 
                $item->update(['is_queue'=>true]);
            foreach ($address as $item) {
                $location = Geocoder::geocode($item->address)->get()->first();
                $apikey = GoogleMapsApi::whereApikey(config('geocoder.providers.Geocoder\Provider\Chain\Chain.Geocoder\Provider\GoogleMaps\GoogleMaps.1'))->first();
                $apikey->update(['used_count'=>$apikey->used_count+1]);
                if ($location == null && $item->name) {
                    $location = Geocoder::geocode($item->name)->get()->first();
                    $apikey = GoogleMapsApi::whereApikey(config('geocoder.providers.Geocoder\Provider\Chain\Chain.Geocoder\Provider\GoogleMaps\GoogleMaps.1'))->first();
                    $apikey->update(['used_count'=>$apikey->used_count+1]);
                }
                if ($location) {
                    $data = collect();
                    $temp = collect();
                    foreach ($location->getAdminLevels() as $key => $value) {
                        $temp->put($key,$value?$value->getName():'');
                    }
                    $data->put('levels',$temp);
                    $temp = collect();
                    $temp->put('south',$location->getBounds()->getSouth());
                    $temp->put('west',$location->getBounds()->getWest());
                    $temp->put('north',$location->getBounds()->getNorth());
                    $temp->put('east',$location->getBounds()->getEast());
                    $data->put('bounds',$temp);
                    $data->put('country',$location->getCountry()?$location->getCountry()->getName():'');
                    $data->put('address',$location->getFormattedAddress());
                    $data->put('latitude',$location->getCoordinates()->getLatitude());
                    $data->put('longitude',$location->getCoordinates()->getLongitude());
                    $data->put('longitude',$location->getCoordinates()->getLongitude());
                    $data->put('name',$item->name);
                    $data->put('original_address_datas_id',$item->id);

                    ConvertedAddressData::updateOrCreate([
                        'original_address_datas_id'=>$item->id,
                    ],$data->toArray());
                    
                    $item->update(['is_converted'=>true,'is_fail'=>false]);
                }
                else{
                    $item->update(['is_fail'=>true,'fail_count'=>$item->fail_count+1]);
                }
            }
        }
        //*/
    }
}
