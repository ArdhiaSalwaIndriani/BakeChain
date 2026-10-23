@extends('supplier.layout')

@section('title', 'Riwayat Pengiriman')
@section('heading', 'Riwayat Pengiriman')
@section('subtitle', 'Catatan pengiriman bahan yang telah kamu lakukan.')

@section('content')
<div class="panel">
    <form method="GET" action="{{ route('supplier.riwayat') }}" class="filters">
        <div class="field">
            <label for="dari">Dari Tanggal</label>
            <input type="date" id="dari" name="dari" value="{{ $dari }}">
        </div>
        <div class="field">
            <label for="sampai">Sampai Tanggal</label>
            <input type="date" id="sampai" name="sampai" value="{{ $sampai }}">
        </div>
        <button type="submit" class="btn">Terapkan</button>
        <a href="{{ route('supplier.riwayat') }}" class="btn btn-light">Reset</a>
    </form>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Tgl Kirim</th>
                    <th>Kode Pembelian</th>
                    <th>Bahan</th>
                    <th>Jumlah</th>
                    <th>Catatan Pengiriman</th>
                    <th>Diterima</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengiriman as $item)
                    <tr>
                        <td>{{ $item->dikirim_at ? \Carbon\Carbon::parse($item->dikirim_at)->locale('id')->translatedFormat('j F Y H:i') : '-' }}</td>
                        <td><a class="link" href="{{ route('supplier.permintaan.show', $item->id) }}">{{ $item->kode_pembelian }}</a></td>
                        <td>{{ $item->nama_bahan }}</td>
                        <td>{{ (float) $item->jumlah }} {{ $item->satuan }}</td>
                        <td>{{ $item->catatan_pengiriman ?: '-' }}</td>
                        <td>{{ $item->diterima_at ? \Carbon\Carbon::parse($item->diterima_at)->locale('id')->translatedFormat('j F Y H:i') : '-' }}</td>
                        <td><span class="badge st-{{ \Illuminate\Support\Str::slug($item->status) }}">{{ ucfirst($item->status) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="empty">Belum ada riwayat pengiriman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @include('supplier._pager', ['paginator' => $pengiriman])
</div>
@endsection