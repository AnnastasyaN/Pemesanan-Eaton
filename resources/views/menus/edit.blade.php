@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center">
        <div class="card shadow-sm border-0 rounded-3 my-4" style="max-width: 500px; width: 100%;">
            <div class="card-header bg-dark text-warning" style="color: #ee9632;">
                <h4 class="mb-0">Edit Menu Makanan</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('menus.update', $menu->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Makanan</label>
                        <input type="text" name="nama" id="nama" class="form-control"
                            value="{{ old('nama', $menu->nama) }}" required style="border-color: #ee9632;">
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <textarea name="kategori" id="kategori" class="form-control" rows="3" required style="border-color: #ee9632;">{{ old('kategori', $menu->kategori) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" name="harga" id="harga" class="form-control"
                            value="{{ old('harga', $menu->harga) }}" required style="border-color: #ee9632;">
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto (opsional)</label>
                        <input type="file" name="foto" id="foto" class="form-control"
                            style="border-color: #ee9632;">
                        @if ($menu->foto && file_exists(public_path('uploads/' . $menu->foto)))
                            <p class="mt-3">Foto saat ini:</p>
                            <img src="{{ asset('uploads/' . $menu->foto) }}" alt="Foto Menu" width="150"
                                class="rounded shadow-sm">
                        @endif
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('menus.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-dark" style="color: #ee9632;">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
