<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseSponsorship extends Model
{
    use HasFactory;

    protected $fillable = [ 'house_id', 'sponsorship_id'];

}
