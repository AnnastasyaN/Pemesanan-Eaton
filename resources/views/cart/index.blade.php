@extends('layouts.app')

@section('content')
    <style>
        .custom-small-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="container py-5">
        <h2 class="mb-4 fw-bold text-dark">Keranjang Belanja</h2>

        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}',
                });
            </script>
        @endif

        @if (count($cart) > 0)
            <div class="table-responsive shadow rounded">
                <table class="table table-hover align-middle mb-0 bg-white">
                    <thead class="thead-dark text-white" style="background-color: #2f2f2f;">
                        <tr>
                            <th>Produk</th>
                            <th class="text-center">Harga Satuan</th>
                            <th class="text-center">Kuantitas</th>
                            <th class="text-center">Total Harga</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $id => $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('uploads/' . $item['foto']) }}"
                                            class="custom-small-img rounded border me-3" alt="{{ $item['nama'] }}">
                                        <div>{{ $item['nama'] }}</div>
                                    </div>
                                </td>
                                <td class="text-center">Rp{{ number_format($item['harga'], 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <form action="{{ route('cart.update', $id) }}" method="POST"
                                        class="d-inline-flex align-items-center gap-1">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" name="action" value="decrease"
                                            class="btn btn-sm btn-outline-secondary">−</button>
                                        <input type="text" name="quantity" value="{{ $item['quantity'] }}" readonly
                                            class="form-control form-control-sm text-center" style="width: 50px;">
                                        <button type="submit" name="action" value="increase"
                                            class="btn btn-sm btn-outline-secondary">+</button>
                                    </form>
                                </td>
                                <td class="text-center text-danger fw-semibold">
                                    Rp{{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-danger btn-delete-item"
                                        data-id="{{ $id }}" data-nama="{{ $item['nama'] }}"
                                        data-action="{{ route('cart.remove', $id) }}">
                                        <i class="bi bi-trash-fill"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        <thead class="text-dark" style="background-color: #dcdcdc;">
                            <td colspan="3" class="text-end fw-bold">Total Pemesanan</td>
                            <td class="text-center text-primary fw-bold">
                                Rp{{ number_format($total, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('checkout.form') }}" class="btn btn-success rounded-pill">
                                    <i class="bi bi-cart-check-fill me-1"></i> Checkout
                                </a>
                            </td>
                            </tr>
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center mt-5 text-muted">
                <p class="mb-3">Keranjang kamu kosong.</p>
                <a href="{{ route('menu.index') }}" class="btn btn-outline-primary">← Kembali ke Menu</a>
            </div>
        @endif
    </div>

    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const deleteButtons = document.querySelectorAll('.btn-delete-item');
                const deleteForm = document.getElementById('delete-form');

                deleteButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const actionUrl = this.dataset.action;
                        const itemName = this.dataset.nama;

                        Swal.fire({
                            title: 'Hapus Item?',
                            text: `Kamu yakin ingin menghapus "${itemName}" dari keranjang?`,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                deleteForm.setAttribute('action', actionUrl);
                                deleteForm.submit();
                            }
                        });
                    });
                });
            });
        </script>
    @endpush
@endsection
