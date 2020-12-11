@component('mail::message')
    # Login with magic link

    The body of your message.

    @component('mail::button', ['url' => $link])
        Login
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
