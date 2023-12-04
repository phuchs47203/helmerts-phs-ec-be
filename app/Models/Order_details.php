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
        'sale_price',
        'size_name',
        'size_id'
    ];

    public function detailsOrder()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    // public function productOderDetails(): HasOne
    // {
    //     return $this->hasOne(Product::class, 'product_id', 'id');
    // }
    // public function orderDetailSize(): HasOne
    // {
    //     return $this->hasOne(Product_size::class, 'size_id');
    // }

    public function productOderDetails()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function orderDetailSize()
    {
        return $this->belongsTo(Product_size::class, 'size_id', 'id');
    }
}
