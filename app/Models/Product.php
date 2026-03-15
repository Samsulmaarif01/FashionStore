<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'category', 'category_id', 'price', 'discount_percent',
        'description', 'image', 'badge', 'stock', 'is_active',
    ];

    public function getDiscountedPriceAttribute()
    {
        if ($this->discount_percent > 0) {
            return $this->price * (1 - ($this->discount_percent / 100));
        }
        return $this->price;
    }

    public function category_rel()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    protected $casts = [
        'is_active' => 'boolean',
        'price'     => 'integer',
        'stock'     => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
