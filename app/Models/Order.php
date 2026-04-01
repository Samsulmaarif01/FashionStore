<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_number', 'status',
        'total_amount', 'shipping_address', 'payment_method', 'notes', 'paid_at',
        'cancel_reason', 'shipped_at', 'completed_at',
    ];

    protected $casts = [
        'paid_at'      => 'datetime',
        'shipped_at'   => 'datetime',
        'completed_at' => 'datetime',
        'total_amount' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'Menunggu Konfirmasi',
            'processing' => 'Diproses',
            'shipped'    => 'Dikirim',
            'completed'  => 'Selesai',
            'cancelled'  => 'Dibatalkan',
            default      => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'amber',
            'processing' => 'blue',
            'shipped'    => 'indigo',
            'completed'  => 'green',
            'cancelled'  => 'red',
            default      => 'gray',
        };
    }
}
