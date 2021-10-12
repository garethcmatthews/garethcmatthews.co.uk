<div class="list-group list-group-flush border-bottom scrollarea">
    @php $dark = false; @endphp
    @foreach ($projects as $project)
        <div class="list-group-item py-3@php echo ($dark = !$dark)? ' row-dark' : ''; @endphp">
            <div class="d-flex w-100">
                <img src="{{ url('img/projects/' . $project['image']) }}" alt="" class="icon">
                <div class="mx-4">
                    <h1 class="mb-1 fs-5">{{ $project['title'] }}</h1>
                    <div class="mb-2 fs-6">{!! $project['description'] !!}</div>
                    <a href="{{ $project['url'] }}" target="_blank" class="btn btn-primary">GitHub Repository</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
