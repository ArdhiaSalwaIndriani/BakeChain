<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $table = 'suppliers';

    protected $fillable = [
        'user_id',
        'nama_supplier',
        'kontak',
        'alamat',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pembelian(): HasMany
    {
        return $this->hasMany(PembelianBahan::class);
    }

    public function batches(): HasMany
    {
        return $this->hasMany(BatchBahan::class);
    }
}