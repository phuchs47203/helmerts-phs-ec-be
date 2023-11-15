<?php

namespace App\Models;

use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Product_category extends Model
{
    use HasFactory, Notifiable;

    
    protected $fillable = [
        'name',
        'description'
    ];
    
    public function productCategory(): HasMany
    {
        return $this->hasMany(Product::class, 'cat_id');
    }
}
