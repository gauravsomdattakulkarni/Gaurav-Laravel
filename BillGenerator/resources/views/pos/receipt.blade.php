<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $bill->bill_id }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            width: 320px;
            margin: 0 auto;
            color: #000;
            background: #fff;
            font-size: 14px;
            padding: 20px 10px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .border-top { border-top: 1px dashed #000; margin-top: 10px; padding-top: 10px; }
        .border-bottom { border-bottom: 1px dashed #000; margin-bottom: 10px; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 5px 0; }
        .store-name { font-size: 22px; font-weight: bold; margin-bottom: 5px; }
        @media print {
            body { width: 100%; padding: 0; }
        }
    </style>
</head>
<body>

    <div class="text-center store-name">POS SUPERMARKET</div>
    <div class="text-center border-bottom">123 Retail Avenue, City Center</div>
    
    <div>Date: {{ $bill->created_at->format('d M Y, h:i A') }}</div>
    <div>Bill No: #{{ $bill->bill_id }}</div>
    <div class="border-bottom">Cashier: {{ session('pos_username', 'Admin') }}</div>
    
    <table>
        <thead>
            <tr class="border-bottom border-top">
                <th style="text-align: left;">Item</th>
                <th class="text-right">Amt</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bill->items_data as $item)
            <tr>
                <td>
                    {{ $item['product_name'] }}<br>
                    <small>{{ $item['product_code'] }}</small>
                </td>
                <td class="text-right font-bold">₹{{ number_format($item['product_price_after_discount'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="border-top border-bottom">
        <table>
            <tr>
                <td>Total Items</td>
                <td class="text-right font-bold">{{ $bill->total_items }}</td>
            </tr>
            <tr>
                <td class="font-bold" style="font-size: 18px;">GRAND TOTAL</td>
                <td class="text-right font-bold" style="font-size: 18px;">₹{{ number_format($bill->total_amount, 2) }}</td>
            </tr>
        </table>
    </div>
    
    <div class="text-center" style="margin-top: 20px;">
        <div class="font-bold">Thank You For Shopping!</div>
        <div>Please Visit Again</div>
    </div>
    
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>