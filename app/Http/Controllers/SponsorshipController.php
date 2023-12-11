<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SponsorshipController extends Controller
{
    public function selectSponsorship(house $house)
    {
        $user_id = Auth::user()->id;
        if ($user_id !== $house->user_id) {
            return redirect()->route('admin.houses.index');
        }
        $sponsorships = Sponsorship::all();
        return view('admin.sponsorships.selectSponsorship', compact('house', 'sponsorships'));
    }

    public function payment(Request $request, $id){
        // dd($request);
        // $sponsorship = Sponsorship::all();
        $data = $request->all();
        $house = House::find($id);

        $now = date_create();
        $start_date = date_create();

        if ($data['sponsorship_id'] == 1) {
            date_add($now, date_interval_create_from_date_string("24 hours"));
            $expiration = date_format($now, 'Y-m-d H:i:s');
        } elseif ($data['sponsorship_id'] == 2) {
            date_add($now, date_interval_create_from_date_string("72 hours"));
            $expiration = date_format($now, 'Y-m-d H:i:s');
        } else {
            date_add($now, date_interval_create_from_date_string("144 hours"));
            $expiration = date_format($now, 'Y-m-d H:i:s');
        }

        if ($house->sponsorships()->exists(['house_id' => $house->id])) {
            abort('403', 'Promozione già attiva su questo appartamento');
        } else {

            $formatStartDate = date_format($start_date, 'Y-m-d H:i:s');
            $house->sponsorships()->attach($data['sponsorship_id'], ['start_date' => $formatStartDate, 'end_date' => $expiration]);
        }


        $house->save();

        return redirect()->route('admin.houses.show', $house);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\Sponsorship  $sponsorship
     * @return \Illuminate\Http\Response
     */
    public function show(Sponsorship $sponsorship)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sponsorship  $sponsorship
     * @return \Illuminate\Http\Response
     */
    public function edit(Sponsorship $sponsorship)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sponsorship  $sponsorship
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sponsorship $sponsorship)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sponsorship  $sponsorship
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sponsorship $sponsorship)
    {
        //
    }
}