<?php

namespace App\Models;

use App\Models\Order_details;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product_size extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'size',
        'available',
        'sold'
    ];
    public function productSize()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function orderDetailSize():HasMany
    {
        return $this->hasMany(Order_details::class, 'size_id');
    }
}
