@push("stylesheets")
    <link rel="stylesheet" href="{{ url('css/links.css') }}" />
@endpush
@extends("App::.layouts.main")
@section("page")
    <div class="page">
        <x-site-navigation menu="main-menu" view="top-navigation" title="Links" />
        @include("Links::links")
    </div>
@endsection
