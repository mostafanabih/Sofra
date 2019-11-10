<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Resturant extends Authenticatable
{

    protected $table = 'resturants';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'password', 'neighborhood_id', 'delivery_fees', 'minimum', 'contact_phone', 'whats_app', 'category_id', 'image', 'state','api_token','pin_code','status');
    protected $hidden = [
        'password', 'api_token',
    ];
    public function tokens()
    {
        return $this->morphMany('App\Models\Token', 'tokenable');
    }

    public function notifications()
    {
        return $this->morphMany('App\Models\Notification', 'notificationable');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function neighborhood()
    {
        return $this->belongsTo('App\Models\Neighborhood');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }

    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }
    public function scopeActive($query){
        return $query->where('status','active');
    }

}
