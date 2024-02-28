<!-- resources/views/orders/confirmation.blade.php -->

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>注文完了</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- 他の必要なCSSやJavaScriptのリンクを追加 -->
</head>
<body class="bg-gray-900 text-white font-sans">
    <div class="flex flex-col min-h-screen">
        @include('includes.header')

        <!-- メインコンテンツ -->
        <div class="flex-grow container mx-auto my-8 p-8 bg-gray-800 rounded-md shadow-md text-center">
            <h2 class="text-3xl font-bold mb-8">注文が完了しました</h2>
            <p class="text-gray-400 mb-8">ご注文いただき、ありがとうございます。</p>
            <!-- 明細書ダウンロードページへのボタン -->
            <a href="{{ route('canvas') }}" class="bg-blue-500 text-white px-6 py-3 inline-block rounded-md hover:bg-blue-700 focus:outline-none mb-4">明細書をダウンロード</a>
            <a href="{{ route('products.productList') }}" class="bg-purple-500 text-white px-6 py-3 inline-block rounded-md hover:bg-purple-700 focus:outline-none">ホームに戻る</a>
        </div>

        
        <!-- フッター -->
        @include('includes.footer')
    </div>
</body>
</html>
