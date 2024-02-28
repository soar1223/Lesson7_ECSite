<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;


class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        
        $imagePath = isset($row['imagepath']) ? $this->storeImage($row['imagepath']) : null;

        // 新しい商品を作成
        $product = new Product([
            'name' => $row['name'],
            'description' => $row['description'],
            'price' => (float) $row['price'],
            'stock_quantity' => (int) $row['stock_quantity'],
            'image' => $imagePath, // ストレージに保存した画像のパス
        ]);

        // CSVファイルのデータを保存
        $product->save();

        // カテゴリの関連付け
        if (isset($row['categories'])) {
            $categoryIds = explode(',', $row['categories']);
            $product->categories()->sync($categoryIds);
        }

        return $product;
    }

    private function storeImage($localPath)
    {
        // ファイルが存在することを確認
        if (!file_exists($localPath)) {
            return null;
        }

        // ファイル名を生成 (ランダムなファイル名を使用)
        $fileName = Str::random(40) . '.' . pathinfo($localPath, PATHINFO_EXTENSION);

        // ファイルをパブリックストレージに保存
        $newPath = Storage::disk('public')->putFileAs(
            'images', // 保存先のディレクトリ
            new \Illuminate\Http\File($localPath), // ファイル
            $fileName // 新しいファイル名
        );

        // 保存されたファイルへのパスを返す
        return $newPath;
    }
}
