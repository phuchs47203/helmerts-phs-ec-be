<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order_details;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'total_price',
        'cus_id',
        'shipping_fee',
        'note',
        'phone_number',
        'country',
        'city',
        'district',
        'address_details',
        'state',
        'payment_status',
        'confirm_by',
        'update_by',
        'shipper_id'
    ];
    public function orders()
    {
        return $this->belongsTo(User::class, 'cus_id');
    }
    public function confirmOrders()
    {
        return $this->belongsTo(User::class, 'confirm_by');
    }
    public function updateOrders()
    {
        return $this->belongsTo(User::class, 'update_by');
    }
    public function shipping()
    {
        return $this->belongsTo(User::class, 'shipper_id');
    }
    public function detailsOrder():HasMany
    {
        return $this->hasMany(Order_details::class, 'order_id');
    }
}
