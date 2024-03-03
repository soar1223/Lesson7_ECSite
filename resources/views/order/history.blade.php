<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>注文履歴</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white">
    <!-- ヘッダー -->
    @include('includes.header')

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">注文履歴</h1>
        @foreach ($orders as $order)
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg mb-4">
                <h2 class="text-xl font-semibold mb-2">注文番号: {{ $order->order_number }}</h2>
                <p class="text-gray-400 mb-4">ステータス: {{ $order->status }}</p>
                <h3 class="font-semibold mb-1">注文アイテム:</h3>
                <ul class="list-disc list-inside mb-4">
                    @php $totalPrice = 0; @endphp
                    @foreach ($order->orderItems as $item)
                        @if ($item->product !== null) <!-- 製品が存在するかチェック -->
                            @php $itemTotal = $item->quantity * $item->product->price; @endphp
                            @php $totalPrice += $itemTotal; @endphp
                            <li>{{ $item->product->name }} - {{ $item->quantity }}個 - {{ number_format($item->product->price) }}円 (小計: {{ number_format($itemTotal) }}円)</li>
                        @else
                            <!-- 製品が存在しない場合の処理、必要に応じてコメントアウトを解除して使用 -->
                            <li>商品情報が利用できません</li>
                        @endif
                    @endforeach
                </ul>
                <p class="text-right font-bold">合計金額: <span class="text-purple-400">{{ number_format($totalPrice) }}円</span></p>
            </div>
        @endforeach
    </div>

    <!-- フッター -->
    @include('includes.footer')
</body>
</html>
