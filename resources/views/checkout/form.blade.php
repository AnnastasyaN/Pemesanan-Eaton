@php
    use Illuminate\Support\Facades\Auth;
@endphp

@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <h2 class="text-left mb-5 fw-bold text-black">
                    <i class="bi bi-bag-check-fill me-2 text-success"></i>Checkout Pesanan
                </h2>

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="card shadow-sm border-0 rounded-4" style="background-color: #fff;">
                    <div class="card-body p-4">

                        <form method="POST" action="{{ route('checkout.process') }}">
                            @csrf

                            {{-- Informasi Pelanggan --}}
                            <div class="mb-4">
                                <h4 class="mb-3 text-dark">
                                    <i class="bi bi-person-lines-fill me-2 text-success"></i>Informasi Pelanggan
                                </h4>

                                <div class="mb-3">
                                    <label class="form-label">Nama <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_pelanggan" class="form-control rounded-3"
                                        value="{{ old('nama_pelanggan') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <textarea name="alamat" rows="3" class="form-control rounded-3">{{ old('alamat') }}</textarea>
                                </div>
                            </div>

                            {{-- Ringkasan Pesanan --}}
                            <div class="mb-4">
                                <h4 class="mb-3 text-dark">
                                    <i class="bi bi-cart-check-fill me-2 text-success"></i>Produk Dipesan
                                </h4>
                                <div class="table-responsive">
                                    <table class="table table-striped align-middle">
                                        <thead class="table-success text-center">
                                            <tr>
                                                <th>Produk</th>
                                                <th>Jumlah</th>
                                                @if (Auth::user()->role !== 'admin')
                                                    <th class="text-end">Subtotal</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($cart as $item)
                                                <tr>
                                                    <td>{{ $item['nama'] }}</td>
                                                    <td class="text-center">{{ $item['quantity'] }}</td>
                                                    @if (Auth::user()->role !== 'admin')
                                                        <td class="text-end">
                                                            Rp {{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}
                                                        </td>
                                                    @endif
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted">Keranjang kosong.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Rincian Pembayaran --}}
                            @if (Auth::user()->role !== 'admin')
                                <div class="mb-4">
                                    <h4 class="mb-3 text-dark">
                                        <i class="bi bi-credit-card-2-front-fill me-2 text-success"></i>Rincian Pembayaran
                                    </h4>
                                    <ul class="list-group shadow-sm rounded-3">
                                        <li class="list-group-item d-flex justify-content-between bg-light">
                                            <span>Subtotal Pesanan</span>
                                            <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between bg-success text-white">
                                            <span class="fw-bold">Total Pembayaran</span>
                                            <span class="badge bg-light text-success fs-6">
                                                Rp {{ number_format($total, 0, ',', '.') }}
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            @endif

                            {{-- Tombol Submit --}}
                            <div class="d-grid">
                                <button type="submit" class="btn btn-lg btn-success rounded-pill shadow-sm">
                                    <i class="bi bi-cash-coin me-2"></i>Buat Pesanan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
