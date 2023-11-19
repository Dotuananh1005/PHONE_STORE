<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 */
class CartProduct extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'cart_product';
    /**
     * @var string[]
     */
    protected $fillable = ['cart_id', 'product_id', 'quantity', 'product_size_id', 'price', 'total_price'];


    /**
     * @return BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * @return BelongsTo
     */
    public function productSize()
    {
        return $this->belongsTo(ProductSize::class, 'product_size_id');
    }

    /**
     * @return BelongsTo
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

}
