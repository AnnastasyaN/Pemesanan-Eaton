@extends('layouts.app')

@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #f0f4f8, #d9e2ec);
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .main-container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 30px 25px;
            background-color: #ffffffdd;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            transition: box-shadow 0.3s ease;
        }

        .main-container:hover {
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.18);
        }

        h1 {
            margin-bottom: 25px;
            color: #343a40;
            font-weight: 700;
            font-size: 2.5rem;
            text-align: center;
            letter-spacing: 1px;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 15px auto 25px;
            font-weight: 600;
            text-align: center;
            max-width: 600px;
            box-shadow: 0 2px 8px rgba(21, 87, 36, 0.3);
        }

        /* Search Form Styling */
        .search-form {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        .search-input {
            width: 300px;
            padding: 10px 14px;
            border: 2px solid #ced4da;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .btn-search {
            padding: 10px 24px;
            background-color: #343a40;
            border: none;
            color: white;
            font-weight: 700;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            flex-shrink: 0;
        }

        .btn-search:hover {
            background-color: #949494;
        }

        .btn-add {
            padding: 10px 24px;
            background-color: #007bff;
            color: white;
            font-weight: 700;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            flex-shrink: 0;
        }

        .btn-add:hover {
            background-color: #0056b3;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        th,
        td {
            padding: 14px 12px;
            text-align: center;
        }

        th {
            background-color: #343a40;
            color: white;
            font-weight: 600;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        tbody tr {
            background-color: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        tbody tr:hover {
            background-color: #f8f9fa;
        }

        td {
            vertical-align: middle;
            border-bottom: none;
        }

        /* Image in table */
        td img {
            border-radius: 8px;
            max-width: 100px;
            height: auto;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        td img:hover {
            transform: scale(1.05);
        }

        /* Buttons inside table */
        .btn {
            margin: 2px 5px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            color: white;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
            cursor: pointer;
            border: none;
        }

        .btn-edit {
            background-color: #28a745;
        }

        .btn-edit:hover {
            background-color: #1e7e34;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        .btn-delete:hover {
            background-color: #bd2130;
        }

        /* Responsive */
        @media (max-width: 700px) {
            .search-form {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-add {
                width: 100%;
                text-align: center;
            }

            .btn-search {
                width: 100%;
            }

            td img {
                max-width: 80px;
            }
        }
    </style>

    <div class="main-container">
        <h1>Menu</h1>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" action="{{ route('menus.index') }}" class="search-form">
            <input type="text" name="search" placeholder="Cari menu..." value="{{ request('search') }}"
                class="search-input" autocomplete="off">
            <button type="submit" class="btn btn-search"><i class="bi bi-search"></i> Cari</button>
            <a href="{{ route('menus.create') }}" class="btn btn-add"><i class="bi bi-plus-circle"></i> Tambah Menu</a>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($menus as $menu)
                    <tr>
                        <td><img src="{{ asset('uploads/' . $menu->foto) }}" alt="{{ $menu->nama }}"></td>
                        <td>{{ $menu->nama }}</td>
                        <td>{{ $menu->kategori }}</td> <!-- Menampilkan kategori -->
                        <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-edit">Edit</a>
                            <!-- Tombol trigger modal hapus -->
                            <button type="button" class="btn btn-delete" data-bs-toggle="modal"
                                data-bs-target="#confirmDeleteModal{{ $menu->id }}">
                                Hapus
                            </button>

                            <!-- Modal konfirmasi hapus -->
                            <div class="modal fade" id="confirmDeleteModal{{ $menu->id }}" tabindex="-1"
                                aria-labelledby="confirmDeleteLabel{{ $menu->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-3">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmDeleteLabel{{ $menu->id }}">Konfirmasi
                                                Hapus</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            Apakah Anda yakin ingin menghapus menu <strong>{{ $menu->nama }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <form action="{{ route('menus.destroy', $menu->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 20px; font-weight: 600; color: #666;">Menu tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>


    </div>
@endsection
