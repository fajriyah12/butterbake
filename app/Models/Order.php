<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_number', 'status', 'delivery_method',
        'delivery_address', 'delivery_city', 'delivery_postal_code',
        'pickup_date', 'subtotal', 'delivery_fee', 'total',
        'payment_method', 'payment_status', 'notes',
    ];

    protected $casts = [
        'pickup_date' => 'datetime',
        'subtotal' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber(): string
    {
        do {
            $number = 'BB-' . str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
            } 
            while (self::where('order_number', $number)->exists());
            return $number;
            }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'    => 'Pending',
            'processing' => 'Processing',
            'ready'      => 'Ready',
            'completed'  => 'Completed',
            'cancelled'  => 'Cancelled',
            default      => ucfirst($this->status),
        };
    }

    public function orders()
    {
    return $this->hasMany(Order::class);
    }
}