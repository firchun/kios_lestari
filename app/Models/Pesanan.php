<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pesanan extends Model
{
    use HasFactory;
    protected $table = 'pesanan';
    protected $guarded = [];

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public static function generateInvoiceNumber()
    {
        // Ambil data invoice terbaru berdasarkan id
        $lastInvoice = self::latest()->first();

        if (!$lastInvoice) {
            return 'INV-00001'; // Jika tidak ada invoice sebelumnya, mulai dari INV-00001
        }

        // Pastikan $lastInvoice adalah instance dari model Invoice
        if ($lastInvoice instanceof self) {
            // Extract number and increment
            $number = intval(substr($lastInvoice->no_invoice, 4)) + 1;
        } else {
            // Jika $lastInvoice bukan instance dari Invoice (harusnya tidak terjadi)
            $number = 1; // Mulai dari nomor 1 jika terjadi situasi yang tidak terduga
        }

        // Generate new invoice number
        $newInvoiceNumber = 'INV-' . str_pad($number, 5, '0', STR_PAD_LEFT);

        return $newInvoiceNumber;
    }
}
