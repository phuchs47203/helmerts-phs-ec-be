<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'cus_id',
        'product_id',
        'order_id',
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
    public function orderComments()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
