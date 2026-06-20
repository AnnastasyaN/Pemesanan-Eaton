<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf;

class CheckoutController extends Controller
{
    public function form()
    {
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(function ($item) {
            return $item['harga'] * $item['quantity'];
        });

        return view('checkout.form', compact('cart', 'total'));
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'nullable|string',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('checkout.form')->with('error', 'Keranjang kosong.');
        }

        $total = collect($cart)->sum(fn($item) => $item['harga'] * $item['quantity']);
        $grandTotal = $total ;

        $order = Order::create([
            'nama_pelanggan' => $validated['nama_pelanggan'],
            'alamat' => $validated['alamat'],
            'total' => $grandTotal,
        ]);

        foreach ($cart as $item) {
            $order->details()->create([
                'produk' => $item['nama'],
                'quantity' => $item['quantity'],
                'harga' => $item['harga'],
            ]);
        }

        // Simpan total pesanan ke session agar bisa ditampilkan di halaman sukses
        session()->put('order_total', $grandTotal);
        session()->put('cart_backup', $cart);

        // Hapus isi keranjang
        session()->forget('cart');

        // Redirect ke halaman sukses
        return redirect()->route('checkout.success');
    }

    public function success()
    {
        return view('checkout.success');
    }


    public function cetakPDF()
    {
        $cart = session('cart_backup', []); // pakai backup jika cart sudah dikosongkan
        $total = session('order_total', 0);

        $pdf = Pdf::loadView('checkout.invoice', compact('cart', 'total'));
        return $pdf->download('invoice-pesanan.pdf');
    }
}
