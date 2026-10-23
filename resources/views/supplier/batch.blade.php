@extends('supplier.layout')

@section('title', 'Informasi Batch')
@section('heading', 'Informasi Batch')
@section('subtitle', 'Batch bahan yang kamu pasok, diurutkan dari kedaluwarsa terdekat (FEFO).')

@section('content')
<div class="panel">
    <form method="GET" action="{{ route('supplier.batch') }}" class="filters">
        <div class="field">
            <label for="status">Status Batch</label>
            <select id="status" name="status">
                <option value="">Semua status</option>
                @foreach (['disiapkan', 'dikirim', 'tersedia', 'habis', 'kadaluarsa'] as $status)
                    <option value="{{ $status }}" @selected($statusAktif === $status)>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn">Terapkan</button>
        <a href="{{ route('supplier.batch') }}" class="btn btn-light">Reset</a>
    </form>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Kode Batch</th>
                    <th>Bahan</th>
                    <th>Jumlah</th>
                    <th>Pembelian</th>
                    <th>Tgl Masuk</th>
                    <th>Kedaluwarsa</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($batches as $batch)
                    @php
                        $kadaluarsa = $batch->tanggal_kadaluarsa;
                        $dekat = $kadaluarsa <= $batasPeringatan;
                    @endphp
                    <tr>
                        <td><strong>{{ $batch->kode_batch }}</strong></td>
                        <td>{{ $batch->nama_bahan }}</td>
                        <td>{{ (float) $batch->jumlah }} {{ $batch->satuan }}</td>
                        <td>
                            @if ($batch->pembelian_bahan_id)
                                <a class="link" href="{{ route('supplier.permintaan.show', $batch->pembelian_bahan_id) }}">{{ $batch->kode_pembelian }}</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $batch->tanggal_masuk ? \Carbon\Carbon::parse($batch->tanggal_masuk)->locale('id')->translatedFormat('j F Y') : '-' }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($kadaluarsa)->locale('id')->translatedFormat('j F Y') }}
                            @if ($dekat)
                                <small style="color:#B60000;font-weight:600">Segera kedaluwarsa</small>
                            @endif
                        </td>
                        <td><span class="badge st-{{ \Illuminate\Support\Str::slug($batch->status) }}">{{ ucfirst($batch->status) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="empty">Belum ada batch bahan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @include('supplier._pager', ['paginator' => $batches])
</div>
@endsection