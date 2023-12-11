<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\House;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
  public function index()
  {
    $user_id = Auth::user()->id;
    $houses = House::select('id','user_id','title','cover_image','description', 'rooms','sq_meters','beds','bathrooms','address')
    ->where('user_id', $user_id)
    ->with('messages:id,text,house_id', 'sponsorships:id,name,duration,price')
    ->paginate(12);
    foreach ($houses as $house) {
        $house->description = strlen($house->description) > 100 ? substr($house->description, 0, 100) . '...' : $house->description;
    }
    
    // per i messaggi
    $messages = [];

    $messagesList = House::join('messages', 'messages.house_id', '=', 'houses.id')
      ->where('houses.user_id', '=', $user_id)
      ->orderBy('messages.created_at', 'desc')->get();

    foreach ($messagesList as $message) {
      array_push($messages, $message);
    }
    // fine messaggi

    $houseSponsorshipList = House::select('id','user_id','title','cover_image','description', 'rooms','sq_meters','beds','bathrooms','address')
    ->where('user_id', $user_id)
    ->with('sponsorships:id,name,duration,price')
    ->join('house_sponsorship', 'houses.id', '=', 'house_sponsorship.house_id')
    ->select('houses.*')
    ->get();


    return view('admin.dashboard', compact("houses", "messages", 'houseSponsorshipList'));
  }
}