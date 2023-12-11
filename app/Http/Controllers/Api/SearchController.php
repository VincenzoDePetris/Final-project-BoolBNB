<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Extra;
use App\Models\House;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $houses = House::paginate(12);
        foreach ($houses as $house) {
            $house->cover_image = Storage::url($house->cover_image);
        };
        return response()->json($houses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function houseByFilters(Request $request)
    {
        $filters = $request->all();

        $houses_query = House::query();

        if ($filters['activeFilters']['activeAddress'] !== null) {

            // * ++++ gestione latitudine e longitudine
            // *forzo il fatto di non usare la verifica ssl
            $client = new Client([
                'verify' => false, // Ignora la verifica SSL
            ]);
            // inserisco l'indirizzo fornito nella chiamata api tomtom
            $position = $client->get('https://api.tomtom.com/search/2/geocode/' . $filters['activeFilters']['activeAddress'] . '.json?key=t7a52T1QnfuvZp7X85QvVlLccZeC5a9P');

            $data_position = json_decode($position->getBody(), true);

            // distribuisco il valore di lat e lon ai campi del db
            $latitude = $data_position['results'][0]['position']['lat'];
            $longitude = $data_position['results'][0]['position']['lon'];

            $raggio = $filters['activeFilters']['activeRange'];

            // $raggio = 80;
            $presetRadius = 6371;
            //
            $lat1 = deg2rad($latitude);
            $lon1 = deg2rad($longitude);

            //Filtro per distanza

            $houses_query->selectRaw("*,
            ($presetRadius * ACOS(
                COS(RADIANS(latitude)) * COS($lat1) * COS(RADIANS(longitude) - $lon1) +
                SIN(RADIANS(latitude)) * SIN($lat1)
            )) AS distance");
            $houses_query->having('distance', '<', $raggio);

            $houses_query->orderBy('distance');
        }

        // Handle extra filter
        if (!empty($filters['activeFilters']['activeExtras'])) {
            foreach ($filters['activeFilters']['activeExtras'] as $extra) {
                $houses_query->whereHas('extras', function ($query) use ($extra) {
                    $query->where('extra_id', $extra);
                });
            }
        }

        // Handle bathrooms filter
        if (!empty($filters['activeFilters']['bathrooms'])) {
            $bathrooms = $filters['activeFilters']['bathrooms'];
            if ($bathrooms === '5') {
                $houses_query->where('bathrooms', '>=', 5);
            } else {
                $houses_query->where('bathrooms', '=', $bathrooms);
            }
        }

        // Handle rooms filter
        if (!empty($filters['activeFilters']['rooms'])) {
            $rooms = $filters['activeFilters']['rooms'];
            if ($rooms === '5') {
                $houses_query->where('rooms', '>=', 5);
            } else {
                $houses_query->where('rooms', '=', $rooms);
            }
        }

        // Handle beds filter
        if (!empty($filters['activeFilters']['beds'])) {
            $beds = $filters['activeFilters']['beds'];
            if ($beds === '5') {
                $houses_query->where('beds', '>=', 5);
            } else {
                $houses_query->where('beds', '=', $beds);
            }
        }

        $houses = $houses_query->with('extras:id,name,color,icon,icon_vue','galleries')
        ->orderBy('id', 'desc')
        ->paginate(12);

        foreach($houses as $house){
              $house->description = $house->getAbstract(100);
              $house->cover_image = Storage::url($house->cover_image);
         };

        return response()->json($houses);
    }
}