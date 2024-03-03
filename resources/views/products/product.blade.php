<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品詳細</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- 他の必要なCSSやJavaScriptのリンクを追加 -->
</head>
<body class="bg-gray-900 text-white font-sans">
    <div class="flex flex-col min-h-screen">
        <!-- ヘッダー -->
        @include('includes.header')

        <!-- メインコンテンツ -->
        <div class="flex-grow container mx-auto my-8 p-8 bg-gray-800 rounded-md shadow-md">
            <h2 class="text-3xl font-bold mb-8">商品詳細</h2>

            <!-- 商品詳細 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- 商品画像 -->
                <div>
                    @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-64 object-contain">
                    @else
                        <div class="flex items-center justify-center w-full h-64 bg-gray-900 text-white text-lg">
                            画像なし
                        </div>
                    @endif
                </div>

                <!-- 商品情報 -->
                <div>
                    <h3 class="text-2xl font-bold mb-4">{{ $product->name }}</h3>
                    <p class="text-gray-400 mb-4">価格: {{ number_format($product->price) }}円</p>
                    <p class="text-gray-400 mb-4">商品説明: {{ $product->description }}</p>
                    
                    @auth
                        @if(Auth::user()->is_admin == 0)
                            <!-- カートに追加ボタン、管理者でないログインユーザーにのみ表示 -->
                            <form action="{{ route('cart.add') }}" method="post" class="flex items-center">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <label for="quantity" class="mr-2">数量:</label>
                                <input type="number" id="quantity" name="quantity" min="1" value="1" class="bg-gray-800 text-white border border-gray-600 p-2 w-16 text-center">
                                <button type="submit" class="ml-2 bg-purple-500 text-white px-4 py-2 rounded-md hover:bg-purple-700 focus:outline-none">カートに追加</button>
                            </form>
                        @endif
                    @endauth

                    <!-- 管理者機能 -->
                    @auth
                        @if(Auth::user()->is_admin == 1)
                            <div class="flex items-center mt-4">
                                <!-- 更新ボタン -->
                                <a href="{{ route('products.edit', ['id' => $product->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                                    更新
                                </a>
                                <!-- 削除ボタン -->
                                <form action="{{ route('products.destroy', ['id' => $product->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        削除
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        <!-- フラッシュメッセージ -->
        @if (session('success'))
            <div id="flash-message" class="fixed top-0 right-0 bg-green-500 text-white px-4 py-2 m-4 rounded">
                {{ session('success') }}
            </div>
            
            <script>
                setTimeout(() => {
                    const flashMessage = document.getElementById('flash-message');
                    if (flashMessage) {
                        flashMessage.style.display = 'none';
                    }
                }, 3000); // メッセージを3秒後に消す
            </script>
        @endif

        <!-- フッター -->
        @include('includes.footer')
    </div>
</body>
</html>
