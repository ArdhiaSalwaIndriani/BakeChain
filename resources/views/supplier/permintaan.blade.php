@extends('supplier.layout')

@section('title', 'Permintaan Bahan')
@section('heading', 'Permintaan Bahan')
@section('subtitle', 'Kebutuhan bahan baku dari bakery yang perlu kamu penuhi.')

@section('content')
<div class="panel">
    <form method="GET" action="{{ route('supplier.permintaan') }}" class="filters">
        <div class="field">
            <label for="q">Cari</label>
            <input type="text" id="q" name="q" value="{{ $keyword }}" placeholder="Kode atau nama bahan">
        </div>
        <div class="field">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="">Semua status</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" @selected($statusAktif === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn">Terapkan</button>
        <a href="{{ route('supplier.permintaan') }}" class="btn btn-light">Reset</a>
    </form>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Bahan</th>
                    <th>Jumlah</th>
                    <th>Tgl Pesan</th>
                    <th>Estimasi Kirim</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($permintaan as $item)
                    <tr>
                        <td><strong>{{ $item->kode_pembelian }}</strong></td>
                        <td>{{ $item->nama_bahan }}</td>
                        <td>{{ (float) $item->jumlah }} {{ $item->satuan }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pesan)->locale('id')->translatedFormat('j F Y') }}</td>
                        <td>{{ $item->tanggal_estimasi_kirim ? \Carbon\Carbon::parse($item->tanggal_estimasi_kirim)->locale('id')->translatedFormat('j F Y') : '-' }}</td>
                        <td><span class="badge st-{{ \Illuminate\Support\Str::slug($item->status) }}">{{ ucfirst($item->status) }}</span></td>
                        <td><a class="link" href="{{ route('supplier.permintaan.show', $item->id) }}">Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="empty">Tidak ada permintaan bahan yang sesuai.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @include('supplier._pager', ['paginator' => $permintaan])
</div>
@endsection