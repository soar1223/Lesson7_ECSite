<!-- ヘッダー -->
<header class="bg-gray-800 py-4">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-bold"><a href="{{ route('products.productList') }}" class="text-white hover:text-blue-300">NexGaming</a></h1>
        <nav>
            @auth
                <!-- ログイン中の名前の文字色を緑に変更 -->
                <span class="text-green-500 px-4 py-2">ログイン中: {{ Auth::user()->name }}</span>
                
                <!-- ログアウトフォームの追加 -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <!-- ログアウトボタンの文字色を赤に変更 -->
                    <button type="submit" class="text-red-500 hover:text-red-700 px-4 py-2">ログアウト</button>
                </form>
                
                @if(Auth::user()->is_admin == 1)
                    <a href="{{ route('products.create') }}" class="text-gray-400 hover:text-white px-4 py-2">商品登録</a>
                @endif
            @endauth
            <a href="{{ route('products.productList') }}" class="text-gray-400 hover:text-white px-4 py-2">ホーム</a>
            <a href="{{ route('carts.cart') }}" class="text-gray-400 hover:text-white px-4 py-2">カート</a>
            @auth
                @if(Auth::user()->is_admin == 1)
                    <a href="{{ route('admin.orders') }}" class="text-gray-400 hover:text-white px-4 py-2">注文履歴</a>
                @else
                    <a href="{{ route('order.history') }}" class="text-gray-400 hover:text-white px-4 py-2">注文履歴</a>
                @endif
            @endauth
        </nav>
    </div>
</header>
