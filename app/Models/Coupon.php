<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 */
class Coupon extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'coupon';
    protected $attributes = [
        'status' => 'new',
    ];
    /**
     * @var string[]
     */
    protected $fillable = ['content', 'status', 'count','value'];

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
