<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total',
        'status',
    ];

    // Define the relationship to the User (Customer)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship to Order Items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
