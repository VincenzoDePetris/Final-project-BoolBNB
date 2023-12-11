<?php

namespace App\Http\Controllers;

use App\Http\Requests\HouseStoreRequest;
use App\Http\Requests\HouseUpdateRequest;
use App\Models\Extra;
use App\Models\Gallery;
use App\Models\House;
use App\Models\Sponsorship;
use DateTimeImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $houses = House::select('id','user_id','title','cover_image','description', 'rooms','sq_meters','beds','bathrooms','address')
        ->with('extras:id,name,color,icon,icon_vue', 'sponsorships:id,name,price,duration')
        ->orderby('id', 'desc')
        ->where('user_id', $user_id)
        ->paginate(12);
        foreach ($houses as $house) {
            $house->description = strlen($house->description) > 30 ? substr($house->description, 0, 30) . '...' : $house->description;
        }
        return view("admin.houses.index", compact("houses"));
    }

    /**
     * Show the form for creating a new resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function create(House $house)
    {
        $extras = Extra::all();        
        $extra_house = $house->extras->pluck('id')->toArray();
        return view("admin.houses.create", compact("house", "extras", "extra_house"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HouseStoreRequest $request)
    {
        $data = $request->validated();

        // prendo id user dallo user loggato
        $user = Auth::user();

        $house = new House;
        
        $house->user_id = Auth::user()->id;
        if($request->hasFile('cover_image')){
            $data['cover_image'] = Storage::put('uploads/houses/cover_image', $data['cover_image']);
        }

        // user_id viene valorizzato in base a chi è collegato
        $house->user_id = $user->id;

        // * ++++ gestione latitudine e longitudine
        // *forzo il fatto di non usare la verifica ssl
        $client = new Client([
            'verify' => false, // Ignora la verifica SSL
        ]);
        // inserisco l'indirizzo fornito nella chiamata api tomtom
        $response = $client->get('https://api.tomtom.com/search/2/geocode/' . $data['address'] . '.json?key=t7a52T1QnfuvZp7X85QvVlLccZeC5a9P');

        $data_position = json_decode($response->getBody(), true);

        // distribuisco il valore di lat e lon ai campi del db
        $house->latitude = $data_position['results'][0]['position']['lat'];
        $house->longitude = $data_position['results'][0]['position']['lon'];
        
        $house->fill($data);
        $house->save();

        if ($request->hasFile('image')) {
            $images = $request->file('image');
            foreach ($images as $image) {
                $gallery = new Gallery;
                $gallery->house_id = $house->id;
                $path = $image->store('uploads/houses/gallery_images');
                $gallery->fill(['image' => $path]);
                $gallery->save();
            }
        };

        // dd($house);
        
        if(Arr::exists($data, "extras")) $house->extras()->attach($data["extras"]);

        return redirect()->route('admin.houses.show', $house);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\House  $house
     * return \Illuminate\Http\Response
     */
    public function show(House $house)
    {
        $user_id = Auth::user()->id;
        if ($user_id !== $house->user_id) {
            return redirect()->route('admin.houses.index');
        }
        $extras = Extra::all();  
        $user = Auth::user();
        $gallery_images = Gallery::all()->where('house_id',$house->id);

        $sponsorship = $house->sponsorships->last();
        $house_sponsorship = DB::table('house_sponsorship')->where('house_id', $house->id)->orderByDesc('id')->first();
        // dd($house_sponsorship);
        if ($house_sponsorship) {
            $date = new DateTimeImmutable($house_sponsorship->end_date);
            $house_sponsorship->end_date = $date->format('Y-m-d H:i');
        }

        return view('admin.houses.show', compact('house', 'user', 'extras', 'gallery_images', 'sponsorship', 'house_sponsorship'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\House  $house
     * @return \Illuminate\Http\Response
     */
    public function edit(House $house)
    {        
        $user_id = Auth::user()->id;
        if($user_id==$house->user_id){
            $extras = Extra::orderBy('name')->get();
            $extra_house = $house->extras->pluck('id')->toArray();
            return view("admin.houses.edit", compact("house", "extras", "extra_house"));

        }

        return redirect()->route('admin.houses.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\House  $house
     * @return \Illuminate\Http\Response
     */
    public function update(HouseUpdateRequest $request, House $house)
    {
        $data = $request->validated();
        
        if ($request->hasFile('cover_image')) {
            if ($house->cover_image) {
                Storage::delete($house->cover_image);
            }
            $data['cover_image'] = Storage::put('uploads/houses/cover_image', $data['cover_image']);
        };


        if ($request->hasFile('image')) {
            $images = $request->file('image');
            foreach ($images as $image) {
                $gallery = new Gallery;
                $gallery->house_id = $house->id;
                $path = $image->store('uploads/houses/gallery_images');
                $gallery->fill(['image' => $path]);
                $gallery->save();
            }
        };

        $house->fill($data);
        $house->save();

        if(Arr::exists($data, "extras"))
            $house->extras()->sync($data["extras"]);
        else
            $house->extras()->detach();
        

        return redirect()->route('admin.houses.show', $house);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\House  $house
     * @return \Illuminate\Http\Response
     */
    public function destroy(House $house)
    {
        {
            $house->delete();
            return redirect()->route("admin.houses.index")
                ->with('message_type', 'danger')
                ->with('message', 'Progetto messo nel cestino con successo');
            ;
        }
    }

    public function trash()
    {
        $houses = House::orderby('id', 'desc')->onlyTrashed()->paginate(8);
        foreach ($houses as $house) {
            $house->description = strlen($house->description) > 100 ? substr($house->description, 0, 100) . '...' : $house->description;
        }
        return view("admin.houses.trash.index", compact("houses"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\House  $house
     * *@return \Illuminate\Http\Response
     */

    public function forceDestroy(int $id)
    {
        $house = House::onlyTrashed()->findOrFail($id);
      


        if ($house->cover_image) {
            Storage::delete($house->cover_image);
        }

        $house->forceDelete();
        return redirect()->route("admin.houses.trash.index")
            ->with('message_type', 'danger')
            ->with('message', 'Progetto eliminato con successo');
        ;
    }


    public function restore(int $id)
    {
        $house = House::onlyTrashed()->findOrFail($id);
        $house->restore();
        return redirect()->route("admin.houses.trash.index")
            ->with('message_type', 'success')
            ->with('message', 'Progetto ripristinato con successo');
    }

}