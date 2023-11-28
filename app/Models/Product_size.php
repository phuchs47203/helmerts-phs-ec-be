<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
