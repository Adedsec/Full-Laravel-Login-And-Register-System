@if (session('registered'))
    <div class="alert alert-success">
        @lang('auth.your registration was successful')
    </div>
@endif
@if (session('wrongCredentials'))
    <div class="alert alert-danger">
        @lang('auth.user or pass is wrong')
    </div>
@endif
@if (session('emailHasVerified'))
    <div class="alert alert-success">
        @lang('auth.email has verified')
    </div>
@endif
@if (session('resetLinkSent'))
    <div class="alert alert-success">
        @lang('auth.reset link sent')
    </div>
@endif
@if (session('resetLinkFailed'))
    <div class="alert alert-danger">
        @lang('auth.reset link failed')
    </div>
@endif

@if (session('cantChangePassword'))
    <div class="alert alert-danger">
        @lang('auth.cant change password')
    </div>
@endif
@if (session('passwordChanged'))
    <div class="alert alert-success">
        @lang('auth.password changed')
    </div>
@endif

@if (session('magicLinkSent'))
    <div class="alert alert-success">
        @lang('auth.magic link sent')
    </div>
@endif

@if (session('invalidToken'))
    <div class="alert alert-danger">
        @lang('auth.invalid token')
    </div>
@endif

@if (session('cantSendCode'))
    <div class="alert alert-danger">
        @lang('auth.cant send code')
    </div>
@endif

@if (session('invalidCode'))
    <div class="alert alert-danger">
        @lang('auth.invalid code')
    </div>
@endif

@if (session('twoFactorActivated'))
    <div class="alert alert-success">
        @lang('auth.two factor activated')
    </div>
@endif

@if (session('twoFactorDeactivated'))
    <div class="alert alert-success">
        @lang('auth.two factor deactivated')
    </div>
@endif

@if (session('codeResent'))
    <div class="alert alert-success">
        @lang('auth.code resent')
    </div>
@endif
