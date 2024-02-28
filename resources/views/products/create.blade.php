<!-- resources/views/products/create.blade.php -->

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品登録</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- 他の必要なCSSやJavaScriptのリンクを追加 -->
</head>
<body class="bg-gray-900 text-white font-sans">
    @include('includes.header')
    <div class="flex-grow container mx-auto my-8 p-8 bg-gray-800 rounded-md shadow-md">
        <h2 class="text-3xl font-bold mb-8">商品登録</h2>

        <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-400">商品名</label>
                <input type="text" name="name" id="name" class="mt-1 p-2 w-full text-gray-900">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-400">商品説明</label>
                <textarea name="description" id="description" class="mt-1 p-2 w-full text-gray-900"></textarea>
            </div>

            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-400">価格</label>
                <input type="number" name="price" id="price" class="mt-1 p-2 w-full text-gray-900">
            </div>

            <div class="mb-4">
                <label for="stock_quantity" class="block text-sm font-medium text-gray-400">在庫数量</label>
                <input type="number" name="stock_quantity" id="stock_quantity" class="mt-1 p-2 w-full text-gray-900">
            </div>

            <div class="mb-4">
                <label for="categories" class="block text-sm font-medium text-gray-400">カテゴリ</label>
                <select name="categories[]" id="categories" multiple class="mt-1 p-2 w-full text-gray-900">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <p class="text-sm text-red-500">カテゴリが見つからない場合は、下部から追加してください。</p>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-400">商品画像</label>
                <input type="file" name="image" id="image" class="mt-1 p-2 w-full text-gray-900">
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="bg-purple-500 text-white px-4 py-2 rounded-md hover:bg-purple-700 focus:outline-none">登録</button>
            </div>
        </form>
        <div class="mt-10">
            <h3 class="text-2xl font-bold mb-4">カテゴリ追加</h3>
            <form id="category-form" action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="category_name" class="block text-sm font-medium text-gray-400">カテゴリ名</label>
                    <input type="text" name="category_name" id="category_name" class="mt-1 p-2 w-full text-gray-900" required>
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none">カテゴリ追加</button>
                </div>
            </form>
        <div class="mt-10">
            <h3 class="text-2xl font-bold mb-4">CSVファイルから商品を一括登録</h3>
            <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="csv_file" class="block text-sm font-medium text-gray-400">CSVファイル</label>
                    <input type="file" name="csv_file" id="csv_file" class="mt-1 p-2 w-full text-gray-900" required>
                </div>
                <div class="flex items-center justify-end">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-700 focus:outline-none">インポート</button>
                </div>
            </form>
        </div>
    </div>
    
    @include('includes.footer')
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
</body>
</html>
