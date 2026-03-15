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
        'discount_start', 'discount_end',
        'description', 'image', 'badge', 'stock', 'is_active', 'is_trending',
    ];

    protected $casts = [
        'discount_start' => 'date',
        'discount_end'   => 'date',
        'is_active'      => 'boolean',
        'is_trending'    => 'boolean',
        'price'          => 'integer',
        'stock'          => 'integer',
    ];

    public function getDiscountedPriceAttribute()
    {
        if ($this->is_discount_active) {
            return $this->price * (1 - ($this->discount_percent / 100));
        }
        return $this->price;
    }

    public function getIsDiscountActiveAttribute()
    {
        if ($this->discount_percent <= 0) return false;
        
        $today = now()->startOfDay();
        
        if ($this->discount_start && $today->lt($this->discount_start)) return false;
        if ($this->discount_end && $today->gt($this->discount_end)) return false;

        return true;
    }

    public function category_rel()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }



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
