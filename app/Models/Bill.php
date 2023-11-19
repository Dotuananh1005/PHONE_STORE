<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
        protected $table = 'bill';
    protected $fillable = [
        'user_id', 'date', 'customer_address', 'total_price', 'status', 'customer_email', 'customer_name', 'customer_phone', 'product', 'payment_method'
    ];
    protected $casts = [
        'product' => 'array'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product')
            ->withPivot('quantity', 'price','product_size', 'total_price')
            ->withTimestamps();
    }
    
}
