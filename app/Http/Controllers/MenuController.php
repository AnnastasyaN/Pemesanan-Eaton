<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;


class MenuController extends Controller
{
 public function index(Request $request)
{
    $menus = Menu::withSum('orderItems as total_dipesan', 'quantity')
        ->when($request->search, function ($query, $search) {
            return $query->where('nama', 'like', '%' . $search . '%');
        })
        ->get();

    $orders = [];

    // Cek apakah user adalah admin
    if (Auth::check() && Auth::user()->role === 'admin') {
    $orders = Order::with(['orderItems.menu', 'user'])->latest()->take(10)->get();
}


    return view('menus.index', compact('menus', 'orders'));
}



    public function create()
    {
        return view('menus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
            'harga' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $menu = new Menu($request->only('nama', 'harga', 'kategori'));

        if ($request->hasFile('foto')) {
            $imageFile = $request->file('foto');
            $filename = time() . '.' . $imageFile->getClientOriginalExtension();

            $img = Image::read($imageFile->getRealPath());
            $img->resize(400, 300)->save(public_path('uploads/' . $filename));

            $menu->foto =  $filename;
        }

        $menu->save();

        return redirect()->route('menus.index')->with('success', 'Menu berhasil disimpan');
    }

    public function show(Menu $menu)
    {
        return view('menus.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        return view('menus.edit', compact('menu'));
    }

   public function update(Request $request, Menu $menu)
{
    $request->validate([
        'nama' => 'required',
        'kategori' => 'required',
        'harga' => 'required',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $data = [
        'nama' => $request->nama,
        'harga' => $request->harga,
        'kategori' => $request->kategori,  // Menambahkan kategori
    ];

    // Jika ada file baru diupload
    if ($request->hasFile('foto')) {
        $imageFile = $request->file('foto');
        $filename = time() . '.' . $imageFile->getClientOriginalExtension();
        $fullPath = public_path('uploads/' . $filename);

        // Simpan gambar baru
        Image::read($imageFile->getRealPath())
            ->resize(400, 300)
            ->save($fullPath);

        // Hapus foto lama jika ada
        if ($menu->foto && file_exists(public_path('uploads/' . $menu->foto))) {
            unlink(public_path('uploads/' . $menu->foto));
        }

        // Simpan nama file baru ke database
        $data['foto'] = $filename;
    }

    // Update menu tanpa menghapus foto jika tidak upload baru
    $menu->update($data);

    return redirect()->route('menus.index')->with('success', 'Menu berhasil diupdate');
}


    public function destroy(Menu $menu)
    {
        if ($menu->foto && file_exists(public_path('uploads/' . $menu->foto))) {
    unlink(public_path('uploads/' . $menu->foto));
}

        $menu->delete();

        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus');
    }
}
