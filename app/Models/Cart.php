<?php
// app/Models/Cart.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts_items';
    protected $fillable = ['user_id', 'product_id', 'quantity'];

    // Product モデルとのリレーションを定義
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    
    // カートに商品を追加
    public function addItem($productId, $quantity)
    {
        // ユーザーがログインしているか確認
        $userId = auth()->id();

        // カートがユーザーごとに管理される場合
        $this->create([
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => $quantity,
        ]);
    }
}
