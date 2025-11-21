<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'max_discount',
        'min_order',
        'usage_limit',
        'used_count',
        'valid_from',
        'valid_until',
        'is_active'
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'value' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'min_order' => 'decimal:2',
    ];

    /**
     * Cek apakah promo code valid
     */
    public function isValid($subtotal = 0)
    {
        // Cek aktif
        if (!$this->is_active) {
            return ['valid' => false, 'message' => 'Kode promo tidak aktif'];
        }

        // Cek tanggal
        $now = now();
        if ($now->lt($this->valid_from) || $now->gt($this->valid_until)) {
            return ['valid' => false, 'message' => 'Kode promo sudah kadaluarsa'];
        }

        // Cek usage limit
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return ['valid' => false, 'message' => 'Kode promo sudah habis digunakan'];
        }

        // Cek minimal order
        if ($subtotal < $this->min_order) {
            return ['valid' => false, 'message' => 'Minimal order Rp ' . number_format($this->min_order, 0, ',', '.')];
        }

        return ['valid' => true, 'message' => 'Kode promo valid'];
    }

    /**
     * Hitung discount amount
     */
    public function calculateDiscount($subtotal)
    {
        if ($this->type === 'percentage') {
            $discount = $subtotal * ($this->value / 100);
            
            // Apply max discount jika ada
            if ($this->max_discount && $discount > $this->max_discount) {
                return $this->max_discount;
            }
            
            return $discount;
        } else {
            // Fixed amount
            return min($this->value, $subtotal); // Tidak bisa lebih dari subtotal
        }
    }

    /**
     * Increment used count
     */
    public function incrementUsage()
    {
        $this->increment('used_count');
    }
}