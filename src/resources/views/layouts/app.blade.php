<html dir="{{ config('settings.application.layout') }}" lang="<?php app()->getLocale(); ?>">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('title') - {{ config('app.name') }}</title>
    <link rel="shortcut icon" href="{{ env('APP_URL') . config('settings.application.company_icon') }}" />
    <link rel="apple-touch-icon" href="{{ env('APP_URL') . config('settings.application.company_icon') }}" />
    <link rel="apple-touch-icon-precomposed"
        href="{{ env('APP_URL') . config('settings.application.company_icon') }}" />
    @include('layouts.includes.header')
    <script>
        window.paymentConfig = <?php echo json_encode([
            'stripePublicKey' => config()->get('services.stripe.public_key'),
            'paypalClientId' => config()->get('services.paypal.client_id'),
            'paypalPaymentMode' => config()->get('services.paypal.mode'),
        ]); ?>
    </script>
</head>

<body>
    <div id="app">
        <div class="container-scroller">
            <!--Top Navbar-->
            @section('nav-bar')
                @include('layouts.includes.navbar')
            @show

            <!--Sidebar-->
            @section('side-bar')
                @include('layouts.includes.sidebar')
            @show

            <div class="container-fluid page-body-wrapper">
                <div class="main-panel">
                    <!--Contents-->
                    @yield('contents')
                </div>
            </div>
        </div>
    </div>

    @include('layouts.includes.footer')
    @push('after-scripts')
        <script>
            $('document').ready(function() {
                $("li:last").hide();
            });
        </script>
    @endpush
</body>

</html>
