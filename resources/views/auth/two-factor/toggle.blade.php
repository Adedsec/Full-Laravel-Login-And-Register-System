@extends('layouts.app')

@section('title','two factor authentication')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            @include('partials.alerts')
            <div class="card">
                <div class="card-header">
                    @lang('auth.two factor')
                </div>
                <div class="card-body text-center">
                    @if (\Illuminate\Support\Facades\Auth::user()->hasTwoFactor())
                        <div>
                            <small>
                                @lang('auth.two factor is activated' , ['number'=> \Illuminate\Support\Facades\Auth::user()->phone_number])
                            </small>
                        </div>
                        <a href="{{route('auth.two.factor.deactivate')}}"
                           class="btn btn-primary mt-5">@lang('auth.deactivate')</a>
                    @else
                        <div>
                            <small>
                                @lang('auth.two factor is inactivated' , ['number'=> \Illuminate\Support\Facades\Auth::user()->phone_number])
                            </small>
                        </div>
                        <a href="{{route('auth.two.factor.activate')}}" class="btn btn-primary mt-5">فعال سازی</a>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
