<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Order;
use App\Models\Comment;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'dateofbirth',
        'phone_number',
        'country',
        'city',
        'district',
        'address_details',
        'imgurl',
        'role',
        'title'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function createBy(): HasMany
    {
        return $this->hasMany(Product::class, 'create_by');
    }
    public function updateBy(): HasMany
    {
        return $this->hasMany(Product::class, 'update_by');
    }
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'cus_id');
    }
    public function confirmOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'confirm_by');
    }
    public function updateOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'update_by');
    }
    public function shipping(): HasMany
    {
        return $this->hasMany(Order::class, 'shipper_id');
    }
    public function userComments(): HasMany
    {
        return $this->hasMany(Comment::class, 'cus_id');
    }
}
