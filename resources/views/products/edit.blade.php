<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品編集</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- 他の必要なCSSやJavaScriptのリンクを追加 -->
</head>
<body class="bg-gray-900 text-white font-sans">

@include('includes.header') <!-- ヘッダーを読み込む -->

<div class="container mx-auto my-8 p-8 bg-gray-800 rounded-md shadow-md">
    <h1 class="text-3xl font-bold mb-8">商品編集</h1>
    <form action="{{ route('products.update', $product->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        
        <div>
            <label for="name" class="block text-sm font-bold text-gray-300">商品名</label>
            <input type="text" id="name" name="name" value="{{ $product->name }}" required class="w-full p-2 rounded bg-gray-700 text-white">
        </div>

        <div>
            <label for="price" class="block text-sm font-bold text-gray-300">価格</label>
            <input type="number" id="price" name="price" value="{{ $product->price }}" required class="w-full p-2 rounded bg-gray-700 text-white">
        </div>

        <div>
            <label for="description" class="block text-sm font-bold text-gray-300">商品説明</label>
            <textarea id="description" name="description" required class="w-full p-2 rounded bg-gray-700 text-white">{{ $product->description }}</textarea>
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 rounded text-white">更新</button>
    </form>
</div>

@include('includes.footer') <!-- フッターを読み込む -->

</body>
</html>
