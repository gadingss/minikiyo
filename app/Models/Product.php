<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'price',
        'stock_quantity',
        'description',
        'category_id',
        'image_url',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

}
