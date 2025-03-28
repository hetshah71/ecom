<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'category',
        'price',
        'quantity',
        'image'
    ];

    protected $table = 'products';

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
