@if ($paginator->hasPages())
    <div class="pager">
        <span>Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }} · {{ $paginator->total() }} data</span>
        <span>
            @if ($paginator->previousPageUrl())
                <a href="{{ $paginator->previousPageUrl() }}">← Sebelumnya</a>
            @endif
            @if ($paginator->nextPageUrl())
                <a href="{{ $paginator->nextPageUrl() }}">Berikutnya →</a>
            @endif
        </span>
    </div>
@endif