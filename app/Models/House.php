<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;


class House extends Model
{
    use HasFactory,SoftDeletes;
    


    protected $fillable=['user_id', 'title','cover_image','description','rooms','sq_meters','beds','bathrooms','address'];
    

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }
    public function views(){
        return $this->hasMany(View::class);
    }
    public function galleries(){
        return $this->hasMany(Gallery::class);
    }

    public function extras(){
        return $this->belongsToMany(Extra::class);
    }
    public function sponsorships(){
        return $this->belongsToMany(Sponsorship::class);
    }

    public function getAbsUriImage(){
        return $this->cover_image ? Storage::url($this->cover_image) : null ;
    }
    public function getAbstract($chars = 50 ){
        return strlen($this->description) > $chars ? substr($this->description, 0, $chars) . "..." : $this->description ;
    }  
    public function getMessagge(){
        $messages = $this->messages->toArray();
        return $messages ? "<i class='fa-solid fa-message'></i>" : null ;
    }  
    public function getSponsorship(){        
            if ($this->sponsorships->toArray()) {
                return "<i class='fa-solid fa-star'></i>";
            } else {
                return null;
            };
    }
}