@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center">
        <div class="card shadow-sm border-0 rounded-3 my-4" style="max-width: 500px; width: 100%;">
            <div class="card-header bg-dark text-warning" style="color: #ee9632;">
                <h4 class="mb-0">Tambah Menu</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Menu</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama menu" required
                            style="border-color: #ee9632;">
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select name="kategori" class="form-select" required style="border-color: #ee9632;">
                            <option value="" disabled selected>Pilih kategori</option>
                            <option value="Makanan">Makanan</option>
                            <option value="Minuman">Minuman</option>
                            <option value="Dessert">Dessert</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" placeholder="Masukkan harga" required
                            style="border-color: #ee9632;">
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        <input type="file" name="foto" class="form-control" style="border-color: #ee9632;">
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('menus.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-dark" style="color: #ee9632;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
