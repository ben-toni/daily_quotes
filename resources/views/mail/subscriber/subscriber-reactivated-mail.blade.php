@component('mail::message')
<center>
    Your account is active!
    <br>
    If you would like to deactivate your account press the button below.
</center>
@component('mail::button', ['url' => $url, 'color' => 'success'])
    {{__('mail.deactivate')}}
@endcomponent
<center>
    {{__('general.thankYou')}},<br>
    <b> {{ config('app.name') }}</b>
</center>
@endcomponent
