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
</div>

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