<?php
/**
 * 
 */
namespace App\Http\Controllers;

use App\GoogleMapsApi;
use Illuminate\Http\Request;

/**
 * 
 */
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
    public function addgoogleapi()
    {
        GoogleMapsApi::firstOrCreate(['apikey'=>request()->apikey]);

        return back();
    }
}
