<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPoduct extends Model
{

    protected $table = 'order_product';
    public $timestamps = true;
    protected $fillable = array('order_id', 'product_id', 'special_order', 'price', 'amount');

}
