<!-- resources/views/cart/cart.blade.php -->

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カート</title>
    <!-- Tailwind CSSのリンク -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- 他の必要なCSSやJavaScriptのリンクを追加 -->
</head>
<body class="bg-gray-900 text-white font-sans">
    <div class="flex flex-col min-h-screen">
        <!-- ヘッダーを挿入 -->
        @include('includes.header')
        <!-- メインコンテンツ -->
        <div class="flex-grow container mx-auto my-8 p-8 bg-gray-800 rounded-md shadow-md">
            <h2 class="text-3xl font-bold mb-8">ショッピングカート</h2>
            @if(empty($cartItems))
                <p class="text-gray-400">カートは空です。</p>
            @else
                <div class="flex flex-col space-y-6">
                    @foreach($cartItems as $cartItem)
                        <div class="flex items-center bg-gray-700 p-4 rounded-md shadow-md">
                            <img src="{{ $cartItem['image'] }}" alt="{{ $cartItem['product']['name'] }}" class="w-32 h-32 object-cover mr-6">
                            <div class="flex-grow">
                                <h3 class="text-xl font-semibold">{{ $cartItem['product']['name'] }}</h3>
                                <p class="text-gray-400">価格: {{ number_format($cartItem['product']['price']) }}円</p>
                            </div>
                            <form action="{{ route('cart.update', $cartItem['id']) }}" method="POST" class="flex items-center">
                                @csrf
                                @method('PATCH')
                                <label for="quantity{{ $cartItem['id'] }}" class="mr-2">数量:</label>
                                <input type="number" id="quantity{{ $cartItem['id'] }}" name="quantity" min="1" value="{{ $cartItem['quantity'] }}" class="bg-gray-800 text-white border border-gray-600 p-2 w-16 text-center mr-4">
                                <!-- 更新ボタンの色を画像と合わせる -->
                                <button type="submit" class="bg-blue-800 text-white px-4 py-2 rounded hover:bg-blue-900 focus:outline-none">更新</button>
                            </form>
                            <form method="POST" action="/cart/{{ $cartItem['id'] }}" class="ml-4">
                                @csrf
                                @method('DELETE')
                                <!-- 削除ボタンの色を赤にし、白いテキストを使用 -->
                                <button type="submit" class="bg-red-800 text-white px-4 py-2 rounded hover:bg-red-900 focus:outline-none">削除</button>
                            </form>
                        </div>
                    @endforeach
                    <!-- 合計金額を表示 -->
                    <div class="text-right text-xl font-bold mt-6">
                        <p>合計金額: {{ number_format($total) }}円</p>
                    </div>
                </div>
                <!-- 注文するボタンをフォームで囲みます。 -->
                <form action="{{ route('order.order') }}" method="POST">
                    @csrf
                    <div class="flex justify-end mt-8">
                        <button type="submit" class="bg-blue-800 text-white px-6 py-3 rounded hover:bg-blue-900 focus:outline-none">注文する</button>
                    </div>
                </form>
            @endif
            <!-- 他の必要なHTMLやJavaScriptのコードを追加 -->
            <!-- 商品リストへ戻るボタン -->
            <div class="flex justify-end mt-4 mb-8">
                <a href="{{ route('products.productList') }}" class="bg-gray-600 text-white px-6 py-3 rounded hover:bg-gray-700 focus:outline-none">
                    商品リストへ戻る
                </a>
            </div>
        </div>
        @include('includes.footer')
        <!-- フラッシュメッセージ -->
        @if (session('success'))
        <div id="flash-message-success" class="fixed top-0 right-0 bg-green-500 text-white px-4 py-2 m-4 rounded">
            {{ session('success') }}
        </div>
        @elseif (session('error'))
        <div id="flash-message-error" class="fixed top-0 right-0 bg-red-500 text-white px-4 py-2 m-4 rounded">
            {{ session('error') }}
        </div>
        @endif

        <!-- メッセージを自動で消すためのJavaScript -->
        <script>
        setTimeout(() => {
            const flashMessageSuccess = document.getElementById('flash-message-success');
            const flashMessageError = document.getElementById('flash-message-error');
            if (flashMessageSuccess) {
                flashMessageSuccess.style.display = 'none';
            }
            if (flashMessageError) {
                flashMessageError.style.display = 'none';
            }
        }, 3000); // 3秒後にメッセージを消す
        </script>

    </div>
</body>
</html>
