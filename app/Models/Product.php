<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $fillable = ['id', 'name', 'price_import', 'price', 'category_id', 'slug', 'information', 'date', 'quantity', 'status', 'image', 'status'];
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            if ($product->quantity > 0) {
                $product->status = 'valid';
            } else {
                $product->status = 'invalid';
            }
        });
    }
    public function carts()
    {
        return $this->hasMany(Cart::class, 'product_id', 'id');
    }
}
