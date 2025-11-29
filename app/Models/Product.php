<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'productdata';
    protected $primaryKey = 'product_id';
    
    protected $fillable = [
        'productName',
        'brand',
        'size',
        'type',
        'load_index',
        'speed_rating',
        'productPrice',
        'productDesc',
        'productImage',
        'bestseller',
    ];
    
    protected function casts(): array
    {
        return [
            'productPrice' => 'decimal:2',
            'bestseller' => 'boolean',
        ];
    }
    
    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'product_id', 'product_id');
    }
    
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'product_id');
    }
}
