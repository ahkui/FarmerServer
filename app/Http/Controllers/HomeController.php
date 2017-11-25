<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GoogleMapsApi;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function googleapi()
    {
        return view('googlemapsapi')->with(['records'=>GoogleMapsApi::get()]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function addgoogleapi(Request $request)
    {
        GoogleMapsApi::firstOrCreate(['apikey'=>$request->apikey]);
        return back();
    }
}
