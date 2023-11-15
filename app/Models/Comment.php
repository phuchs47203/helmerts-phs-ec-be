<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'cus_id',
        'product_id',
        'star',
        'content',
        'imgurl'
    ];
    public function userComments()
    {
        return $this->belongsTo(User::class, 'cus_id', 'id');
    }
    public function productComments()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
