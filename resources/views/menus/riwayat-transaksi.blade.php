@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Riwayat Transaksi</h1>

    @if($orders->isEmpty())
        <div class="alert alert-info">Belum ada transaksi.</div>
    @else
        @foreach($orders as $order)
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <strong>Order ID:</strong> {{ $order->id }} |
                    <strong>Status:</strong> {{ ucfirst($order->status) }} |
                    <strong>Total:</strong> Rp {{ number_format($order->total, 0, ',', '.') }}
                </div>
                <div class="card-body p-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Menu</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->menu->nama ?? '-' }}</td>
                                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rp {{ number_format($item->harga * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
