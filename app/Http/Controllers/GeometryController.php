<?php

namespace App\Http\Controllers;

use App\ConvertedAddressData;
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
        $east = floatval(request()->input('east'));
        $north = floatval(request()->input('north'));
        $south = floatval(request()->input('south'));
        $west = floatval(request()->input('west'));
        return ConvertedAddressData::where('location', 'geoWithin', [
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
