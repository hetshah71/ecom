<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Product;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rec_address',
        'phone',
        'status',
        'user_id',
        'product_id',
        'delivery_status',
        'order_status',
        'payment_status',
        'quantity',
        'invoice_no'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // public function products()
    // {
    //     return $this->belongsTo(Product::class, 'product_id');
    // }
}
