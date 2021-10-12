<div class="list-group list-group-flush border-bottom scrollarea">
    @php $dark = false; @endphp
    @foreach ($links as $link)
        <div class="list-group-item py-3@php echo ($dark = !$dark)? ' row-dark' : ''; @endphp">
            <div class="d-flex w-100">
                <img src="{{ url('img/links/' . $link->image) }}" alt="" class="icon">
                <div class="mx-4">
                    <h1 class="mb-1 fs-5">{{ $link->title }}</h1>
                    <div class="mb-2 fs-6">{!! $link->description !!}</div>
                    <a href="{{ $link->url }}" target="_blank" class="btn btn-primary" role="button">{{ $link->url }}</a>

                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="d-flex justify-content-center">{{ $links->links('App::paginator.pagination') }}</div>
