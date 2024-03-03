<!-- resources/views/products/productList.blade.php -->

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- 他の必要なCSSやJavaScriptのリンクを追加 -->
</head>
<body class="bg-gray-900 text-white font-sans">
    <div class="flex flex-col min-h-screen">
        <!-- ヘッダー -->
        @include('includes.header')

        <!-- メインコンテンツ -->
        <div class="flex-grow container mx-auto my-8 p-8 bg-gray-800 rounded-md shadow-md">
            <h2 class="text-3xl font-bold mb-8">商品一覧</h2>
            <!-- カテゴリ選択プルダウン -->
            <div class="mb-4">
                <select id="category-select" class="p-2 rounded bg-gray-700 text-white">
                    <option value="">カテゴリを選択</option>
                    @foreach($categories as $category)
                        <option value="#category-{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- JavaScript カテゴリセレクト -->
            <script>
                document.getElementById('category-select').addEventListener('change', function() {
                    var selectedCategory = this.value;
                    if (selectedCategory) {
                        window.location.href = selectedCategory;
                    }
                });
            </script>

            <!-- カテゴリごとの商品一覧 -->
            @foreach($categories as $category)
                <section id="category-{{ $category->id }}" class="mb-8">
                    <h3 class="text-2xl font-bold mb-4">{{ $category->name }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($category->products as $product)
                            <div class="bg-gray-700 p-6 rounded-md shadow-md">
                                @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="mb-4 w-full h-64 object-cover">
                                @else
                                    <div class="w-full h-32 bg-gray-900 text-white flex items-center justify-center">
                                        画像なし
                                    </div>
                                @endif
                                <h4 class="text-xl font-semibold">{{ $product->name }}</h4>
                                <p class="text-gray-400">価格: {{ number_format($product->price) }}円</p>
                                <a href="{{ route('products.product', ['id' => $product->id]) }}" class="mt-4 bg-purple-500 text-white px-4 py-2 rounded-md hover:bg-purple-700 focus:outline-none inline-block">詳細を見る</a>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>
        <div class="fixed bottom-4 right-4">
            <button onclick="scrollToTop()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full shadow">
                ↑ ページ上部へ
            </button>
        </div>
        <script>
            function scrollToTop() {
                window.scrollTo({top: 0, behavior: 'smooth'});
            }
        </script>
        <!-- フラッシュメッセージ -->
        @if (session('success'))
            <div id="flash-message" class="fixed top-0 right-0 bg-green-500 text-white px-4 py-2 m-4 rounded">
                {{ session('success') }}
            </div>
            
            <!-- メッセージを自動で消すためのJavaScript -->
            <script>
                setTimeout(() => {
                    const flashMessage = document.getElementById('flash-message');
                    if (flashMessage) {
                        flashMessage.style.display = 'none';
                    }
                }, 2000); // 3秒後にメッセージを消す
            </script>
        @endif
        <!-- フッター -->
        @include('includes.footer')
    </div>
</body>
</html>
