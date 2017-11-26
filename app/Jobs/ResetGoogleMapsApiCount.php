<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\GoogleMapsApi;

class ResetGoogleMapsApiCount implements ShouldQueue
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
        foreach (GoogleMapsApi::get() as $item) 
            $item->update(['used_count'=>0]);
        foreach (OriginalAddressData::whereIsConverted(false)->get() as $item) 
            $item->update(['is_fail'=>false,'is_queue'=>false]);
    }
}
