<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{

public function cetakPDF()
{
    $cart = session('cart', []);
    $total = session('order_total', 0);

    // Simpan riwayat transaksi ke database
    if (Auth::check()) {
        Order::create([
            'user_id' => Auth::id(),
            'items' => json_encode($cart),
            'total' => $total,
        ]);
    }

    $pdf = Pdf::loadView('checkout.invoice', compact('cart', 'total'));
    return $pdf->download('invoice-pesanan.pdf');
}


}
