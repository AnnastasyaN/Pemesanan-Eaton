<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class CartController extends Controller
{
    // Tampilkan isi keranjang
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = array_sum(
            array_map(function ($item) {
                return $item['harga'] * $item['quantity'];
            }, $cart),
        );

        return view('cart.index', compact('cart', 'total'));
    }

    // Tambahkan item ke keranjang
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        $menu = Menu::findOrFail($request->menu_id);

        if (isset($cart[$menu->id])) {
            $cart[$menu->id]['quantity']++;
        } else {
            $cart[$menu->id] = [
                'menu_id' => $menu->id,
                'nama' => $menu->nama,
                'harga' => $menu->harga,
                'quantity' => 1,
                'foto' => $menu->foto,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    // Update jumlah item
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return back()->with('error', 'Item tidak ditemukan');
        }

        if ($request->action == 'increase') {
            $cart[$id]['quantity'] += 1;
        } elseif ($request->action == 'decrease') {
            if ($cart[$id]['quantity'] > 1) {
                $cart[$id]['quantity'] -= 1;
            }
        }

        session()->put('cart', $cart);
        return back()->with('success', 'Keranjang diperbarui');
    }

    // Hapus 1 item dari keranjang
    public function destroy($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Item dihapus dari keranjang!');
        }

        return redirect()->route('cart.index')->with('error', 'Item tidak ditemukan!');
    }

    // Kosongkan seluruh keranjang
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Keranjang telah dikosongkan!');
    }
}
