<?php
/**
 * Homepage Controller
 * PHP Version 7.1
 * 
 * @category Controller
 * @package  App\Http\Controllers
 * @author   ahkui <ahkui@outlook.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     /home Show Homepage
 */

namespace App\Http\Controllers;

use App\GoogleMapsApi;
use Illuminate\Http\Request;

/**
 * Homepage Controller
 * PHP Version 7.1
 * 
 * @category Controller
 * @package  App\Http\Controllers
 * @author   ahkui <ahkui@outlook.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     /home Show Homepage
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

