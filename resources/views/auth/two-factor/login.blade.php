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
                <div class="card-body ">
                    <div class="text-center">
                        <small>
                            @lang('auth.two factor login')
                        </small>
                    </div>
                    <form action="{{route('auth.login.code')}}" method="post" class="p-4">
                        @csrf
                        <div class="form-row mb-3">
                            <input class="form-control" type="text" name="code" id="code"
                                   placeholder="کد را وارد کنید ...">


                        </div>
                        <div class="form-row mt-2">
                            <button class=" btn btn-primary" type="submit">تایید</button>
                            <a href="{{route('auth.two.factor.resend')}}"
                               class="offset-2">@lang('auth.dont receive code ?')</a>
                        </div>
                        @foreach($errors->all() as $error)
                            <ul class="mt-3">
                                <li class="text-danger small">{{$error}}</li>
                            </ul>
                        @endforeach

                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection
