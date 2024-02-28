<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <title>注文詳細</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- html2canvasライブラリ -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
</head>
<body class="bg-white text-black font-sans">
    <div id="content" class="container mx-auto p-8">
        <h1 class="text-center text-2xl font-bold mb-8">注文詳細</h1>

        <!-- 注文情報 -->
        <table class="w-full border-collapse mb-8">
            <tr>
                <td class="border p-2">注文番号：</td>
                <td class="border p-2">{{ $order->order_number }}</td>
            </tr>
            <tr>
                <td class="border p-2">注文日：</td>
                <td class="border p-2">{{ $order->created_at->format('Y/m/d') }}</td>
            </tr>
            <!-- 他の情報もここに追加 -->
        </table>

        <!-- 注文アイテム -->
        <table class="w-full border-collapse mb-8">
            <thead>
                <tr>
                    <th class="border p-2 bg-gray-200">品番</th>
                    <th class="border p-2 bg-gray-200">品名</th>
                    <th class="border p-2 bg-gray-200 text-right">数量</th>
                    <th class="border p-2 bg-gray-200 text-right">単価</th>
                    <th class="border p-2 bg-gray-200 text-right">金額</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderItems as $item)
                <tr>
                    <tr>
                        <td class="border p-2">{{ $item->product_id }}</td>
                        <td class="border p-2">{{ $item->product->name }}</td>
                        <td class="border p-2 text-right">{{ $item->quantity }}</td>
                        <td class="border p-2 text-right">{{ number_format($item->product->price) }}</td>
                        <td class="border p-2 text-right">{{ number_format($item->quantity * $item->product->price) }}</td>
                    </tr>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="text-right font-bold">
            <strong>合計金額: ¥{{ number_format($orderItems->sum(function($item) { return $item->quantity * $item->product->price; })) }}</strong>
        </div>
    </div>

    <!-- ボタンを中央に配置 -->
    <div class="flex justify-center mt-4 mb-8 space-x-4">
        <!-- 画像でダウンロードボタン -->
        <button id="downloadImage" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block cursor-pointer">
            画像でダウンロード
        </button>

        
        <!-- 商品リストへ戻るボタン -->
        <a href="{{ route('products.productList') }}" class="bg-indigo-800 hover:bg-indigo-900 text-white px-6 py-3 rounded focus:outline-none">
            商品リストへ戻る
        </a>

    </div>
    
    <script>
        document.getElementById('downloadImage').addEventListener('click', function() {
            html2canvas(document.getElementById('content')).then(function(canvas) {
                const image = canvas.toDataURL('image/png').replace('image/png', 'image/octet-stream');
                const link = document.createElement('a');
                link.download = '注文明細.png';
                link.href = image;
                link.click();
            });
        });
    </script>
</body>
</html>
