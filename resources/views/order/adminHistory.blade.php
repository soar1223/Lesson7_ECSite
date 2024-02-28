<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理者用注文履歴</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
    <!-- ヘッダー -->
    @include('includes.header')

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">管理者用注文履歴</h1>
        @foreach ($orders as $order)
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg mb-4">
                <h2 class="text-xl font-semibold mb-2">注文番号: {{ $order->order_number }}</h2>
                <p class="text-gray-400 mb-4">ステータス: {{ $order->status }}</p>
                <p class="text-gray-400">名前: {{ $order->user ? $order->user->name : 'ユーザー情報なし' }}様</p>
                <p class="text-gray-400">住所: {{ $order->shipping_address }}</p>
                <p class="text-gray-400">郵便番号: {{ $order->shipping_zip }}</p>
                <p class="text-gray-400 mb-4">電話番号: {{ $order->shipping_phone }}</p>
                <h3 class="font-semibold mb-1">注文アイテム:</h3>
                <ul class="list-disc list-inside mb-4">
                    @foreach ($order->orderItems as $item)
                        <li>{{ $item->product->name }} - {{ $item->quantity }}個 - {{ number_format($item->product->price) }}円</li>
                    @endforeach
                </ul>
                <form action="{{ route('admin.orders.complete', $order->id) }}" method="POST" class="text-right">
                    @csrf
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">ステータスをcompleteに更新</button>
                </form>
            </div>
        @endforeach
    </div>

    <!-- フッター -->
    @include('includes.footer')
</body>
</html>
