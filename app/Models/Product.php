<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';
    public $timestamps = true;
    protected $fillable = array('name', 'ingredients', 'price', 'image', 'price_on_offer', 'order_process_time', 'resturant_id');

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order');
    }

    public function resturant()
    {
        return $this->belongsTo('App\Models\Resturant');
    }

}
