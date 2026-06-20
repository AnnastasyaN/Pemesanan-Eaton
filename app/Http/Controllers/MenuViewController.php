<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuViewController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input pencarian dan kategori dari request
        $search = $request->input('search', '');
        $kategori = $request->input('kategori', '');

        // Ambil semua kategori unik dari tabel Menu
        $categories = Menu::select('kategori')->distinct()->pluck('kategori');

        // Query menu berdasarkan pencarian dan filter kategori
        $menus = Menu::when($search, function ($query, $search) {
                return $query->where('nama', 'like', '%' . $search . '%');
            })
            ->when($kategori, function ($query, $kategori) {
                return $query->where('kategori', $kategori);
            })
            ->get();

        // Kirim data ke view
        return view('menu_view.index', [
            'menus' => $menus,
            'categories' => $categories,
            'search' => $search,
            'selectedKategori' => $kategori
        ]);
    }
}
