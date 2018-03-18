<?php

namespace App\Http\Controllers;

use App\FarmPlace;
use Illuminate\Http\Request;

class GeometryController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $east = floatval(request()->input('east'));
        $north = floatval(request()->input('north'));
        $south = floatval(request()->input('south'));
        $west = floatval(request()->input('west'));

        return FarmPlace::where('location', 'geoWithin', [
            '$geometry' => [
                'type'        => 'Polygon',
                'coordinates' => [
                    [
                        [
                            $east,
                            $north,
                        ],
                        [
                            $west,
                            $north,
                        ],
                        [
                            $west,
                            $south,
                        ],
                        [
                            $east,
                            $south,
                        ],
                        [
                            $east,
                            $north,
                        ],
                    ],
                ],
            ],
        ])->get();
    }
}
