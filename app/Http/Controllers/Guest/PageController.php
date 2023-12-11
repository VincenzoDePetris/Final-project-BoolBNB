<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\House;
use Illuminate\Http\Request;

class PageController extends Controller
{
  public function index()
  {
    $title = "Featured";

    // $houses = House::orderby('id', 'desc')->with('sponsorship: id')->where('sponsorship_id' == 1)->paginate(12);

    return view('guest.home', compact('title'));
  }
}