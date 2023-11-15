<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order_details extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'product_id',
        'note',
        'amount',
        'sale_price'
    ];
    public function productOderDetails(): HasOne
    {
        return $this->hasOne(Product::class, 'product_id', 'id');
    }
    public function detailsOrder()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
