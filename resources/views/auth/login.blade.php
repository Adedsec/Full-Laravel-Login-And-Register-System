@extends('layouts.app')

@section('title',__('auth.login'))

@section('links')
    <script src="https://www.google.com/recaptcha/api.js?hl=fa" async defer></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">

                @include('partials.alerts')

                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-7">
                                {{ __('auth.login') }}
                            </div>
                            <div class="col-sm-5 text-right"><a
                                    href="{{route('auth.magic.login.form')}}"><small>@lang('auth.login without password')</small></a>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('auth.login') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-2 offset-md-1 col-form-label">{{ __('auth.email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-2 offset-md-1 col-form-label">{{ __('auth.password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="current-password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember"
                                               id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('auth.remember me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="offset-sm-3">
                                @include('partials.reCaptcha')
                            </div>
                            <div class="offset-sm-3">
                                @include('partials.validation-errors')
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-2">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('auth.login') }}
                                    </button>

                                    <a href="{{route('auth.login.provider.redirect','google')}}"
                                       class="btn btn-danger">@lang('auth.login with google')</a>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('auth.password.forget.form') }}">
                                            {{ __('auth.forget your password ?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
