@extends("App::layouts.main")
@push("stylesheets")
    <link rel="stylesheet" href="{{ url('css/projects.css') }}" />
@endpush
@section("page")
    <div class="page">
        <x-site-navigation menu="main-menu" view="top-navigation" title="Projects" />
        @include("Projects::projects")
    </div>
@endsection
