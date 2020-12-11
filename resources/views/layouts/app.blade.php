<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script>@yield('javascript')</script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font.css') }}" rel="stylesheet">

    @yield('links')
</head>
<body>
<div id="app">

    @include('partials.navbar')

    @if (session('mustVerifyEmail'))
        <div class="alert alert-danger alert-dismissible fade show m-2 d-inline-block "
             role="alert">
            <p class="d-inline mr-4">@lang('auth.must verify your email', ['link'=> route('auth.email.send.verification')])</p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session('emailVerificationEmailSent'))
        <div class="alert alert-success alert-dismissible fade show m-2 d-inline-block "
             role="alert">
            <p class="d-inline mr-4">@lang('auth.verification email sent')</p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <main class="container py-5">
        @yield('content')
    </main>
</div>
</body>
</html>
