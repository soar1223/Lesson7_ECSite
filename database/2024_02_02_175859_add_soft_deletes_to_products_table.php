<?php
// database/migrations/2024_02_02_175859_add_soft_deletes_to_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToProductsTable extends Migration // クラス名を変更
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->softDeletes(); // SoftDeletesカラム（deleted_at）を追加
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropSoftDeletes(); // ロールバック時にSoftDeletesカラムを削除
        });
    }
}
