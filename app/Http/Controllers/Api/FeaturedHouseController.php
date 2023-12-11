<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\House;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FeaturedHouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(House $house)
    {
         $houses = House::select('id','user_id','title','cover_image','description', 'rooms','sq_meters','beds','bathrooms','address')
         ->with('extras:id,name,color,icon,icon_vue')
         ->join('house_sponsorship', 'houses.id', '=', 'house_sponsorship.house_id')
         ->select('houses.*')
         ->paginate(12);
         foreach($houses as $house){
              $house->description = $house->getAbstract(50);
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
        
        $house = House::select('id','user_id','title','cover_image','description', 'rooms','sq_meters','beds','bathrooms','address', 'longitude', 'latitude')
            ->where('id', $id)->with('user:id,name,last_name','extras','galleries')->first();
            // modifica path immagine per farla leggere correttamente da vue
            
            if(!$house) 
            abort(404, 'House not found');
        
        $house->cover_image = $house->getAbsUriImage();

        // $house = House::find($id);

        return response()->json($house);
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
}