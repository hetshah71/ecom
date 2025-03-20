<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
    protected $fillable = [
        'title',
        'description',
        'category',
        'price',
        'quantity',
        'image'
    ];

    protected $table = 'products';
    
    
}