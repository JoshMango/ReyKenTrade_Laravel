<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orderdata';
    protected $primaryKey = 'order_id';
    
    protected $fillable = [
        'user_id',
        'total_amount',
        'payment_mode',
        'refNumber',
        'shipping_address',
        'customer_number',
        'order_date',
        'order_status',
    ];
    
    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'order_date' => 'datetime',
        ];
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }
}
