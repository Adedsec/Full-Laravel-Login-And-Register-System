@component('mail::message')
    # Forget Password

    The body of your message.

    @component('mail::button', ['url' => $link])
        Reset
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
