<?php

namespace App\Models;

use App\Models\Product_category;
use App\Models\Order_details;
use App\Models\Comment;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


use JeroenG\Explorer\Application\Explored;
use Laravel\Scout\Searchable;

class Product extends Model implements Explored
{
    use HasFactory,  Searchable;
    protected $fillable = [
        'name',
        'brand',
        'imgurl',
        'description',
        'origional_price',
        'sale_price',
        'discount',
        'available',
        'sold',
        'cat_id',
        'create_by',
        'update_by'
    ];
    public function mappableAs(): array
    {
        return [
            'id' => 'keyword',
            'name' => 'text',
            'created_at' => 'date',
        ];
    }
    public function productCategory()
    {
        return $this->belongsTo(Product_category::class, 'cat_id', 'id');
    }
    public function createBy()
    {
        return  $this->belongsTo(User::class, 'create_by', 'id');
    }
    public function updateBy()
    {
        return $this->belongsTo(User::class, 'update_by', 'id');
    }
    public function productComments(): HasMany
    {
        return $this->hasMany(Comment::class, 'product_id');
    }
    public function productOderDetails()
    {
        return $this->belongsToMany(Order_details::class, 'product_id');
    }


    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray()
    {
        // return [
        //     'name' => $this->name,
        //     'description' => $this->description,
        // ];
        return [
            'name' => $this->name,
        ];
    }
}
