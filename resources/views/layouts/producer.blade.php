<!DOCTYPE html>

<html lang="en">
    <head>
        <base href="./">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="keyword" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @if (isset($title))
            <title>{{ $title }}</title>
        @endif
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('js/producerApp.js') }}" defer></script>

        @yield('css')
        <script>
            window.Laravel = {!!json_encode([
                'csrfToken' => csrf_token(),
                'baseUrl' => url('/'),
            ], JSON_UNESCAPED_UNICODE)!!};
        </script>
    </head>

    <body class="c-app">
        <div id="app">
            @include('include.producer.nav')
            <div class="c-wrapper">
                @include('include.header')
                <div class="c-body">
                    <main class="c-main">
                        @yield('content')
                    </main>
                    @include('include.footer')
                </div>
            </div>
            @if (session()->get('Message.flash'))
                <popup-alert :data="{{json_encode(session()->get('Message.flash')[0])}}"></popup-alert>
            @endif
            @php
                session()->forget('Message.flash');
            @endphp
        </div>
        <script src="{{ asset('js/coreui.bundle.min.js') }}"></script>
        <script src="{{ asset('js/coreui-utils.js') }}"></script>
        @yield('javascript')
    </body>
</html>
