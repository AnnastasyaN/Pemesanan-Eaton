@extends('layouts.app')

@section('content')
    <style>
        body {
            background-color: #f8f9fa;
        }

        .success-wrapper {
            max-width: 650px;
            margin: auto;
            background: #ffffff;
            border-radius: 2rem;
            padding: 3rem;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .success-icon {
            font-size: 4rem;
            color: #4BB543;
            margin-bottom: 1rem;
        }

        .success-title {
            font-size: 2rem;
            font-weight: 700;
            color: #000;
        }

        .success-text {
            font-size: 1.1rem;
            color: #555;
            margin-top: 0.5rem;
            margin-bottom: 2rem;
        }

        .amount-section {
            background: #fff6ec;
            padding: 1.5rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
        }

        .amount-title {
            font-size: 1rem;
            color: #444;
            margin-bottom: 0.3rem;
        }

        .amount-value {
            font-size: 2rem;
            font-weight: 700;
            color: #ee9632;
        }

        .btn-primary-eaton {
            background-color: #ee9632;
            border: none;
            border-radius: 2rem;
            padding: 10px 28px;
            font-weight: 600;
            color: #fff;
            transition: background 0.3s ease;
        }

        .btn-primary-eaton:hover {
            background-color: #d97d1b;
        }

        .btn-outline-eaton {
            background: transparent;
            border: 2px solid #ee9632;
            color: #ee9632;
            border-radius: 2rem;
            padding: 10px 28px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-eaton:hover {
            background-color: #ee9632;
            color: white;
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .small-note {
            margin-top: 2rem;
            color: #777;
            font-size: 0.95rem;
        }
    </style>

    <div class="container py-5">
        <div class="success-wrapper">
            <div class="success-icon">✅</div>
            <div class="success-title">Pesanan Berhasil!</div>
            <div class="success-text">
                Terima kasih telah memesan. Semoga makanan kami jadi favoritmu.<br>
                Sampai jumpa di pesanan berikutnya!
            </div>

            <div class="amount-section">
                <div class="amount-title">Total Belanja Kamu</div>
                <div class="amount-value">Rp{{ number_format(session('order_total', 0), 0, ',', '.') }}</div>
            </div>

            <div class="button-group">
                <a href="{{ route('checkout.cetak') }}" class="btn-outline-eaton">
                    <i class="bi bi-file-earmark-pdf me-2"></i> Cetak Invoice PDF
                </a>
                <a href="{{ route('menu.index') }}" class="btn-primary-eaton">
                    <i class="bi bi-arrow-left-circle me-2"></i> Lihat Menu
                </a>
            </div>

            <div class="small-note">
                Ingin pesan lagi? Keranjang kamu saat ini kosong.
            </div>
        </div>
    </div>
@endsection
