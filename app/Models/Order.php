<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array('amount', 'notes', 'address', 'delivery_fees', 'total_price', 'client_id', 'resturant_id', 'state', 'payment_method', 'commissin', 'cost', 'net');

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withPivot('price','amount','special_order');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function resturant()
    {
        return $this->belongsTo('App\Models\Resturant');
    }

}
