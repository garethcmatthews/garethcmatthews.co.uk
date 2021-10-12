@extends("App::layouts.main")
@push("stylesheets")
    <link rel="stylesheet" href="{{ url('css/technology.css') }}" />
@endpush
@section("page")
    <div class="page">
        <x-site-navigation menu="main-menu" view="top-navigation" title="Contact" />



        <div class="page-content">
            @include('App::common.agents')

@include("Contact::contactform")

        </div>
    </div>
@endsection
