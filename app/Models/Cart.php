<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $products = null;
    public $totalAmount = 0;
    public $total_Price = 0;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->products = $oldCart->products;
            $this->totalAmount = $oldCart->totalAmount;
            $this->total_Price = $oldCart->total_Price;
        }
    }

    static function addRestaurantId( $oldCart , $id) {
        if (!$oldCart)
        {
            session()->put('resturant_id',$id);
        }
    }

    public function add($product, $id) {
        $storedProduct = ['amount' => 0,'special_order' => $product->special_order, 'price' => $product->price,'product_id'=>$id ,'product' => $product];
        if ($this->products) {
            if (array_key_exists($id, $this->products)) {
                $storedProduct = $this->products[$id];
            }
        }
        $storedProduct['amount']++;
        $storedProduct['price'] = $product->price * $storedProduct['amount'];
        $this->products[$id] = $storedProduct;
        $this->totalAmount++;
        $this->total_Price += $product->price;
    }

    public function reduceByOne($id) {
        $this->products[$id]['amount']--;
        $this->products[$id]['price']-= $this->products[$id]['product']['price'];
        $this->totalAmount--;
        $this->total_Price -= $this->products[$id]['product']['price'];

        if ($this->products[$id]['amount'] <= 0) {
            unset($this->products[$id]);
        }
    }

    public function removeItem($id) {
        $this->totalAmount -= $this->products[$id]['amount'];
        $this->total_Price -= $this->products[$id]['price'];
        unset($this->products[$id]);
    }
}
