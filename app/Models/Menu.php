<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['foto', 'nama', 'kategori', 'harga'];

    /**
     * Relasi ke tabel order_items
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
