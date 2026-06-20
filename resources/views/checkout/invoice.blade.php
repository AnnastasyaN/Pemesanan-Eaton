<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice Pesanan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000033;
            padding-bottom: 10px;
        }

        .header h2 {
            color: #000033;
            margin: 0;
        }

        .company-info {
            font-size: 12px;
        }

        .invoice-details {
            margin-top: 20px;
            font-size: 13px;
            line-height: 1.5;
        }

        .invoice-details td {
            padding: 2px 5px;
        }

        .items {
            margin-top: 30px;
            border-collapse: collapse;
            width: 100%;
            font-size: 13px;
        }

        .items thead {
            background-color: #000033;
            color: #fff;
        }

        .items th, .items td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .total {
            margin-top: 10px;
            font-size: 14px;
            text-align: right;
        }

        .signature {
            margin-top: 40px;
            text-align: right;
            font-size: 13px;
        }

        .footer {
            margin-top: 40px;
            border-top: 1px dashed #ccc;
            text-align: center;
            font-size: 12px;
        }

        .thank-you {
            font-family: 'Brush Script MT', cursive;
            font-size: 22px;
            color: #000066;
            margin-top: 20px;
        }

        .highlight {
            color: #cc0000;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>INVOICE</h2>
        <div class="company-info">
            <strong>EatOn Restaurant</strong><br>
            Jl. Lezat No. 123<br>
            Jakarta, Indonesia<br>
            Telp: (021) 1234567
        </div>
    </div>

    <table class="invoice-details" width="100%">
        <tr>
            <td><strong>Invoice #:</strong> INV-{{ rand(1000,9999) }}</td>
            <td><strong>Date:</strong> {{ now()->format('d M Y') }}</td>
        </tr>
        <tr>
            <td><strong>Billed To:</strong> Pelanggan</td>
            <td><strong>Time:</strong> {{ now()->format('H:i') }}</td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th>No</th>
                <th>Menu</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $subtotal = 0;
                $no = 1;
            @endphp
            @foreach ($cart as $item)
                @php $subtotal += $item['harga'] * $item['quantity']; @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item['nama'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>Rp{{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @php $admin = 2000; $grandTotal = $subtotal + $admin; @endphp

    <div class="total">
        <p>Subtotal: Rp{{ number_format($subtotal, 0, ',', '.') }}</p>
        <p>Biaya Admin: Rp{{ number_format($admin, 0, ',', '.') }}</p>
        <p class="highlight">Total Bayar: Rp{{ number_format($grandTotal, 0, ',', '.') }}</p>
    </div>

    <div class="signature">
        <p>TTD Kasir</p>
        <br><br>
        <p><strong>_________________</strong></p>
    </div>

    <div class="thank-you">
        Thank you!
    </div>

    <div class="footer">
        Pesanan ini sah tanpa tanda tangan basah<br>
        EatOn Restaurant – makan praktis, hati puas 🍽️
    </div>
</body>
</html>
