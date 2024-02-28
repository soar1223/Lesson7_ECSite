<?php
// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Product extends Model
{
    use SoftDeletes; // SoftDeletesトレイトを使う
    protected $table = 'products';

    protected $fillable = ['name', 'price', 'description', 'stock_quantity', 'image'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'products_categories', 'product_id', 'category_id');
    }
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }
}

