<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    // Define the relationship to the Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Define the relationship to the Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
