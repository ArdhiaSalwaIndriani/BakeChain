<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BatchBahan extends Model
{
    protected $table = 'batch_bahan';

    protected $fillable = [
        'bahan_baku_id',
        'supplier_id',
        'kode_batch',
        'jumlah',
        'tanggal_masuk',
        'tanggal_kedaluwarsa',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'jumlah' => 'decimal:2',
            'tanggal_masuk' => 'date',
            'tanggal_kedaluwarsa' => 'date',
        ];
    }

    public function bahanBaku(): BelongsTo
    {
        return $this->belongsTo(BahanBaku::class, 'bahan_baku_id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function scopeFefo(Builder $query): Builder
    {
        return $query->orderBy('tanggal_kedaluwarsa')->orderBy('tanggal_masuk');
    }
}