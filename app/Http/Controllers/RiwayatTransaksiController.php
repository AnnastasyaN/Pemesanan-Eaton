<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class RiwayatTransaksiController extends Controller
{
    public function index()
    {
        // Ambil semua order beserta relasinya
        $orders = Order::with(['orderItems.menu'])->latest()->get();

        return view('admin.riwayat-transaksi', compact('orders'));
    }
}
