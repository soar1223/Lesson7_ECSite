<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EcController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web ルート
|--------------------------------------------------------------------------
|
| ここはアプリケーションのウェブルートを登録する場所です。これらの
| ルートは RouteServiceProvider によってロードされ、すべて "web" ミドルウェアグループに
| 割り当てられます。素晴らしいものを作りましょう！
|
*/

// ホームページへのルート
Route::get('/', function () {
    return view('welcome');
});

// ダッシュボードへのルート
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
// ダッシュボードへのアクセスには、認証とメール確認が必要

// 認証が必要なグループ内のルート
Route::middleware('auth')->group(function () {
    // プロフィール編集ページへのルート
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // プロフィールの更新に関するルート
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // プロフィールの削除に関するルート
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 商品リストの表示
    Route::get('/productList', [EcController::class, 'productList'])->name('products.productList');
    // 商品詳細ページの表示
    Route::get('/product/{id}', [EcController::class, 'product'])->name('products.product');
    // カートの表示
    Route::get('/cart', [EcController::class, 'cart'])->name('carts.cart');
    //注文情報入力ページ
    Route::post('/order', [EcController::class, 'order'])->name('order.order');

    // 商品作成ページの表示
    Route::post('/order/place', [EcController::class, 'placeOrder'])->name('order.place');
    // 注文完了ページの表示
    Route::get('/order-confirmation', [EcController::class, 'confirmation'])->name('order.confirmation');
    // 明細書ページへのリンク
    Route::get('/canvas', [EcController::class, 'canvas'])->name('canvas');
    // 注文履歴
    Route::get('/order/history',  [EcController::class, 'history'])->name('order.history');

    // 商品作成処理の実行（フォームのPOSTリクエスト）
    Route::post('/products', [EcController::class, 'store'])->name('products.store');
    //商品をカートに追加
    Route::post('/cart/add', [EcController::class, 'addItem'])->name('cart.add');

    Route::patch('/cart/update/{id}', [EcController::class, 'updateItem'])->name('cart.update');
    //カートから商品削除を行う
    Route::delete('/cart/{id}', [EcController::class, 'deleteItem'])->name('cart.delete');
    
});
Route::middleware(['auth', 'is_admin'])->group(function () {
    // 商品作成ページの表示
    Route::get('/admin/create', [EcController::class, 'create'])->name('products.create');
    // 管理者のみがアクセスできる注文履歴のルート
    Route::get('/admin/orders',  [EcController::class, 'adminOrders'])->name('admin.orders');
    //CSVインポート
    Route::post('/admin/create/import', [EcController::class, 'import'])->name('products.import');
     // カテゴリ作成
    Route::post('/admin/create/category', [EcController::class, 'categoryCreate'])->name('categories.store');
    // 管理者が配送したらステータスをコンプリートにする処理のルート
    Route::post('/admin/orders/{order}/complete', [EcController::class, 'completeOrder'])->name('admin.orders.complete');
    //商品の削除ルート
    Route::delete('/products/{id}', [EcController::class, 'destroy'])->name('products.destroy');
    // 商品の更新ページ
    Route::get('/products/{id}/edit', [EcController::class, 'edit'])->name('products.edit');
     // 商品を更新するルート
    Route::put('/products/{id}',  [EcController::class, 'update'])->name('products.update');
});

// 認証関連のルートを定義したファイルの読み込み
require __DIR__.'/auth.php';



