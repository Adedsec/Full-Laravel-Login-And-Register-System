@component('mail::message')
    # Verify your email

    Dear {{$name}}

    @component('mail::button', ['url' => $link])
        Click To verify
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
