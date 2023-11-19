<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 */
class Cart extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'cart';
    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'product_id', 'quantity', 'price', 'total_price', 'product_name', 'product_size_id'];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function cartProducts(): HasMany
    {
        return $this->hasMany(CartProduct::class, 'cart_id');
    }
}
