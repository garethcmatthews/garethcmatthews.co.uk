@extends("App::layouts.main")
@push("stylesheets")
    <link rel="stylesheet" href="{{ url('css/technology.css') }}" />
@endpush
@section("page")
    <div class="page">
        <x-site-navigation menu="main-menu" view="top-navigation" title="Welcome" />
        <div class="h-100 px-5 py-4 text-white page-header">
            <h4>Welcome to the personal site of Gareth Matthews.</h4>
            <p class="text-white">I am LAMP Stack developer with over 20 years of experience in delivering Open Source, Cross Platform solutions for the web.</p>
            <p class="text-white">Alongside the LAMP Stack I have experience in other tools and platforms - full details are below.</p>
        </div>
        <div class="page-content">
            @include("App::common.agents")
            @include("Technology::technology")
        </div>
    </div>
@endsection
