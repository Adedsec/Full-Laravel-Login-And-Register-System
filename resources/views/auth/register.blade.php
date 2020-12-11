@extends('layouts.app')

@section('title', __('auth.register user'))

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-7">
            @include('partials.alerts')
            <div class="card">
                <div class="card-header">{{ __('auth.register user') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('auth.register') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="email"
                                   class="col-md-2 col-form-label offset-md-1 ">{{ __('auth.email') }}</label>

                            <div class="col-md-8">
                                <input id="email" type="email"
                                       class="form-control @error('email') is-invalid @enderror" name="email"
                                       value="{{ old('email') }}" required autocomplete="email" autofocus
                                       placeholder="@lang('auth.enter your email')">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name"
                                   class="col-md-2 col-form-label offset-md-1">{{ __('auth.name') }}</label>
                            <div class="col-md-8">
                                <input id="name" type="text"
                                       class="form-control @error('name') is-invalid @enderror" name="name"
                                       value="{{ old('name') }}" required autocomplete="name"
                                       placeholder="@lang('auth.enter your name')">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="password"
                                   class="col-md-2 col-form-label offset-md-1">{{ __('auth.password') }}</label>

                            <div class="col-md-8">
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror" name="password"
                                       required autocomplete="new-password"
                                       placeholder="@lang('auth.enter your password')">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm"
                                   class="col-md-2 col-form-label offset-md-1">{{ __('auth.confirmPassword') }}</label>

                            <div class="col-md-8">
                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation" required autocomplete="new-password"
                                       placeholder="@lang('auth.confirm your password')">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone_number"
                                   class="col-md-2 col-form-label offset-md-1">{{ __('auth.phone_number') }}</label>

                            <div class="col-md-8">
                                <input id="phone_number" type="text" class="form-control"
                                       name="phone_number" required placeholder="@lang('auth.enter your phone number')"
                                       value="{{old('phone_number')}}">
                            </div>
                        </div>
                        <div class="offset-sm-3">
                            @include('partials.validation-errors')
                        </div>
                        <div class="form-group row mb-1 mt-1">
                            <div class="col-md-8 offset-md-1">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('auth.register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
