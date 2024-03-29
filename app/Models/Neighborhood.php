<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model 
{

    protected $table = 'neighborhoods';
    public $timestamps = true;
    protected $fillable = array('name', 'city_id');

    public function resturants()
    {
        return $this->hasMany('App\Models\Resturant');
    }

    public function clients()
    {
        return $this->hasMany('App\Models\Client');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

}