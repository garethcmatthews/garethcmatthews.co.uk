<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>GarethCMatthews Lamp/PHP Developer</title>
    <link rel="icon" href="/favicon.ico" />
    <link rel="stylesheet" href="{{ url('css/main.css') }}" />
    @stack('stylesheets')
    <script src="{{ url('js/main.js') }}" defer></script>
    @stack('scripts')
</head>

<body>
    <div class="layout-wrapper">
        <div class="layout-row row">
            <x-site-navigation menu="main-menu" view="side-navigation" />
            <div class="page-wrapper">
                @yield('page')
            </div>
        </div>
    </div>
    <div class="modal fade" id="googlemaps" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Location</h5>
                </div>
                <div class="modal-body text-center">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d19682.731427359133!2d-2.8952402942433446!3d53.19453035610088!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487ac1d9629cf569%3A0x49626cb38dd8f89f!2sChester!5e0!3m2!1sen!2suk!4v1634029757153!5m2!1sen!2suk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
