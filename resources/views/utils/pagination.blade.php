<div class="row">
    <div class="col-md-3 pt-2">
        Showing {{ $paginator->perPage() * ($paginator->currentPage() - 1) + 1 }} to
        {{ $paginator->total()>($paginator->perPage() * $paginator->currentPage())?$paginator->perPage() * $paginator->currentPage():$paginator->total() }} of {{ $paginator->total() }} records
    </div>
    <div class="col-md-9">
        <ul class="pagination pagination-rounded justify-content-center mb-0 float-right">
            @if ($paginator->onFirstPage())
                <li class="page-item">
                    <a class="page-link" href="#">Previous</a>
                </li>
            @else
                <li class="page-item">
                    <button class="page-link" wire:click="previousPage" rel="prev">Previous</button>
                </li>
            @endif

            {{-- Pagination Elements --}}

            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}

                @if (is_string($element))
                    <li class="disabled" aria-disabled="true"><span class="">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><a class="page-link">{{ $page }}</a></li>
                        @else
                            <li class="page-item"><button class="page-link"
                                    wire:click="gotoPage({{ $page }})">{{ $page }}</button></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item"><button class="page-link" wire:click="nextPage" rel="next">Next</button></li>
            @else
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            @endif
        </ul>
    </div>
</div>
