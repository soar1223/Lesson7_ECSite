<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class EcController extends Controller
{
    public function cart()
    {
         // ログインしているユーザーのIDを取得
        $userId = Auth::id();

        // ログインしているユーザーに関連するカートアイテムの情報を取得
        $cartItems = Cart::with('product')->where('user_id', $userId)->get();

        // カートの合計金額を計算
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->quantity * $item->product->price;
        }

        // ビューにカートアイテムと商品情報を渡す
        return view('cart.cart', ['cartItems' => $cartItems ,'total' => $total]);
    }
    
    public function productList()
    {
        // 商品名が存在する商品を含むカテゴリのみを取得する
        $categories = Category::whereHas('products', function ($query) {
            $query->whereNotNull('name');
        })->get();

        return view('products.productList', compact('categories'));
    }

    public function canvas()
    {   
        $user_id = Auth::id();
         // ユーザーIDに基づいて最新の注文を取得
    $order = Order::where('user_id', $user_id)->latest()->first();
    $orderItems = $order->orderItems;

    return view('order.canvas', compact('order', 'orderItems'));
    }

    public function product($id)
    {   
        // 商品情報をデータベースから取得
        $product = Product::find($id);

        // 画像の処理は不要なので削除

        return view('products.product', compact('product'));
    }

    public function Confirmation()
    {
        // 注文完了ページを表示
        return view('order.confirmation');
    }

    public function create()
    {
        // カテゴリ一覧を取得
        $categories = Category::all();

        return view('products.create', compact('categories'));
    }
    
    public function store(Request $request)
    {   
        // バリデーションを実施
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'image' => 'required|image', // 画像ファイルのバリデーション
        ]);

        $imagePath = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // ファイルをストレージのpublicディレクトリに保存し、そのパスを取得
            $imagePath = $request->file('image')->store('public/images');
            // 'public/' プレフィックスを削除して、シンボリックリンクを通してアクセスできるパスを取得
            $imagePath = str_replace('public/', '', $imagePath);
        }

        $product = Product::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'stock_quantity' => $request->input('stock_quantity'),
            'image' => $imagePath, // 画像のパスを保存
        ]);

        // カテゴリの関連付け
        if ($request->has('categories')) {
            $product->categories()->sync($request->input('categories'));
        }

        // 商品作成ページにリダイレクトして成功メッセージを表示
        return redirect()->route('products.create')->with('success', '商品が登録されました。');
    }

    public function addItem(Request $request)
    {
        // 商品IDと数量を取得
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        // 既存のカート内アイテムを確認
        $existingItem = Cart::where('product_id', $productId)
                        ->where('user_id', Auth::id())
                        ->first();

        if ($existingItem) {
            // 既にカートに同じ商品が存在する場合、数量を更新
            $existingItem->quantity += $quantity;
            $existingItem->save();
        } else {
            // Cart モデルを使用してデータベースにアイテムを追加
            $cart = new Cart();
            $cart->addItem($productId, $quantity);
            
        }
        // フラッシュメッセージをセッションに追加
        session()->flash('success', 'カートに追加しました。');
        // 処理後、カートページへリダイレクト
        return redirect()->route('carts.cart');
    }

    public function updateItem(Request $request, $id)
    {
        $cartItem = Cart::find($id);
        $cartItem->quantity = $request->input('quantity');
        $cartItem->save();

        return back()->with('success', 'カートの数量を更新しました。');
    }

    public function deleteItem($id)
    {
        Cart::find($id)->delete();
        return back()->with('success', 'アイテムがカートから正常に削除されました。');
    }
    
    public function order(Request $request)
    {
        // カートの内容から合計金額を計算
        $cartItems = Cart::where('user_id', auth()->id())->get();
        $total = $cartItems->sum(function($cartItem) {
            return $cartItem->quantity * $cartItem->product->price;
        });

        // 現在のユーザーの情報を取得
        $user = auth()->user();

        // 注文ページを表示
        return view('order.order', compact('total', 'user'));
    }
    public function placeOrder(Request $request)
    {
        DB::beginTransaction();

        try {
            $user_id = Auth::id();
            $order = Order::create([
                // オーダー作成の詳細
            ]);

            $cartItems = Cart::with('product')->where('user_id', $user_id)->get();

            foreach ($cartItems as $cartItem) {
                $product = Product::find($cartItem->product_id);
                if ($product->stock_quantity < $cartItem->quantity) {
                    // 在庫不足のエラーメッセージをセッションに設定してカートページにリダイレクト
                    // 商品名をエラーメッセージに含める
                    DB::rollBack(); // トランザクションをロールバック
                    $errorMessage = $product->name.'の在庫が足りません' ;
                    return redirect()->route('carts.cart')->with('error', $errorMessage);
                }

                $order->orderItems()->create([
                    // オーダーアイテム作成の詳細
                ]);

                $product->decrement('stock_quantity', $cartItem->quantity);
                $cartItem->delete();
            }

            DB::commit();
            return redirect()->route('order.confirmation')->with('success', '注文が完了しました。');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('carts.cart')->with('error', '注文処理中にエラーが発生しました: ' . $e->getMessage());
        }
    }

    public function history()
    {
        // ユーザーIDに基づいて注文履歴を取得
        // 'orderItems.product' リレーションで withTrashed() を使用して論理削除された商品も含める
        
        $orders = Order::with(['orderItems.product' => function ($query) {
            $query->withTrashed(); // 論理削除された商品も取得
        }])->where('user_id', auth()->id())
        ->orderBy('created_at', 'desc') // 新しいものから順に並べ替え
            ->get();

        return view('order.history', compact('orders'));
    }

    public function adminOrders()
    {
    
        // 'user' リレーションと、論理削除された商品も含めた 'orderItems.product' リレーションを追加して注文データを取得
        $orders = Order::with(['orderItems.product' => function ($query) {
            $query->withTrashed(); // 論理削除された商品も取得
        }, 'user'])->where('status', 'pending')->get();

        return view('order.adminHistory', compact('orders'));
    }

    public function completeOrder(Request $request, $orderId)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->status = 'complete';
            $order->save();

            // 成功した場合、管理者注文履歴ページにリダイレクト
            return redirect()->route('admin.orders')->with('success', 'Order status updated to complete.');
        } else {
            // 注文が見つからない場合、エラーメッセージを表示
            return back()->with('error', 'Order not found.');
        }
    }

    public function categoryCreate(Request $request)
    {
        // 入力のバリデーション
        $request->validate([
            'category_name' => 'required|max:255',
        ]);

        // 同じ名前のカテゴリが既に存在するか確認
        $existingCategory = Category::where('name', $request->category_name)->first();
        
        if ($existingCategory) {
            // エラーメッセージをセッションに格納し、リダイレクトする
            return redirect()->back()->withInput()->with('error', '指定されたカテゴリは既に存在しています。');
        }
        // カテゴリを新規作成
        Category::create([
            'name' => $request->category_name,
        ]);

        // 商品の create ページにリダイレクトする
        return redirect()->route('products.create')->with('success', '新しいカテゴリが追加されました。');
    }
    
    public function import(Request $request)
    {
        // ファイルのバリデーション（CSVファイルが存在することを確認）
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt', // ファイルタイプはCSV
        ]);

        // CSVファイルをインポート
        Excel::import(new ProductsImport, $request->file('csv_file'));

        // インポートが完了したら、リダイレクト等の処理をここに追加
        return back()->with('success', 'CSVファイルからのインポートが完了しました。');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id); // 商品モデルを使用して商品情報を取得
        return view('products.edit', compact('product')); // 編集ページを表示
    }

        public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete(); // 論理削除実行

        return redirect()->route('products.productList')->with('success', '商品を削除しました。');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            // その他のバリデーションルール
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            // その他の更新するフィールド
        ]);

        // 更新後のリダイレクト先（例：商品詳細ページ）
        return redirect()->route('products.product', $product->id)->with('success', '商品情報が更新されました。');
    }  
}


