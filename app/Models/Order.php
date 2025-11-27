<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Order extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_phone',
        'product_id',
        'quantity',
        'subtotal',
        'discount_amount',
        'promo_code_id',
        'delivery_fee',
        'total_amount',
        'delivery_option',
        'shipping_address',
        'tracking_number',
        'status',
        'completed_at',
        'note',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function ($order) {
            if (empty($order->tracking_number)) {
                $order->tracking_number = 'TRK-' . strtoupper(Str::random(8));
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class);
    }

        // Helper methods
    public function isTakeaway()
    {
        return $this->delivery_option === 'takeaway';
    }

    public function hasPromoCode()
    {
        return !is_null($this->promo_code_id);
    }

    public function getPromoCodeText()
    {
        return $this->promoCode ? $this->promoCode->code : '-';
    }



}
