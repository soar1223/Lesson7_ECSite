<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>注文ページ</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white font-sans">
    <div class="flex flex-col min-h-screen">
        <!-- ヘッダー -->
        @include('includes.header')

        <!-- メインコンテンツ -->
        <div class="flex-grow container mx-auto my-8 p-8 bg-gray-800 rounded-md shadow-md">
            <h2 class="text-3xl font-bold mb-8">注文情報</h2>

            <!-- 注文フォーム -->
            <form action="{{ route('order.place') }}" method="post">
                @csrf
                
                <!-- 氏名 -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-300">氏名</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full bg-gray-800 border border-gray-600 text-white rounded-md shadow-sm p-2"
                    value="{{ old('name', $user->name) }}" required>
                </div>

                <!-- 郵便番号 -->
                <div class="mb-6">
                    <label for="postal_code" class="block text-sm font-medium text-gray-300">郵便番号</label>
                    <input type="text" name="postal_code" id="postal_code" class="mt-1 block w-full bg-gray-800 border border-gray-600 text-white rounded-md shadow-sm p-2"
                        value="{{ old('postal_code', $user->postal_code) }}" required>
                </div>

                <!-- 住所 -->
                <div class="mb-6">
                    <label for="address" class="block text-sm font-medium text-gray-300">住所</label>
                    <input type="text" name="address" id="address" class="mt-1 block w-full bg-gray-800 border border-gray-600 text-white rounded-md shadow-sm p-2"
                        value="{{ old('address', $user->address) }}" required>
                </div>

                <!-- 電話番号 -->
                <div class="mb-6">
                    <label for="phone" class="block text-sm font-medium text-gray-300">電話番号</label>
                    <input type="tel" name="phone" id="phone" class="mt-1 block w-full bg-gray-800 border border-gray-600 text-white rounded-md shadow-sm p-2"
                        value="{{ old('phone', $user->phone) }}" required>
                </div>

                <div class="mb-6 text-left text-xl font-bold">
                    <p>ご請求金額: <span class="text-white">{{ number_format($total) }}円</span></p>
                </div>

                <!-- 注文確定ボタン -->
                <button type="submit" class="bg-purple-500 text-white px-6 py-3 rounded-md hover:bg-purple-700 focus:outline-none">注文確定</button>
            </form>

            <!-- 他の必要なHTMLやJavaScriptのコードを追加 -->
        </div>

        <!-- フッター -->
        @include('includes.footer')
    </div>
</body>
</html>
