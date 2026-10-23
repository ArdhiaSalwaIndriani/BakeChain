<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembelianBahan extends Model
{
    public const STATUS_DIRENCANAKAN = 'direncanakan';
    public const STATUS_DIKONFIRMASI = 'dikonfirmasi';
    public const STATUS_DIKIRIM = 'dikirim';
    public const STATUS_DITERIMA = 'diterima';
    public const STATUS_DITOLAK = 'ditolak';

    protected $table = 'pembelian_bahan';

    protected $fillable = [
        'supplier_id',
        'bahan_baku_id',
        'kode_pembelian',
        'tanggal_pesan',
        'tanggal_estimasi_kirim',
        'jumlah',
        'harga_per_unit',
        'total_estimasi',
        'status',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pesan' => 'date',
            'tanggal_estimasi_kirim' => 'date',
            'jumlah' => 'decimal:2',
            'harga_per_unit' => 'decimal:2',
            'total_estimasi' => 'decimal:2',
        ];
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function bahanBaku(): BelongsTo
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_baku_id');
    }

    public function scopeMilikSupplier(Builder $query, int $supplierId): Builder
    {
        return $query->where('supplier_id', $supplierId);
    }

    public function scopeMenunggu(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_DIRENCANAKAN);
    }
}