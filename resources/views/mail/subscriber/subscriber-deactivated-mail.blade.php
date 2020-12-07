@component('mail::message')
<center>
    {{__('mail.activateAcc')}}
    <br>
    {{__('mail.activeAccountBtnDesc')}}
</center>
@component('mail::button', ['url' => $url, 'color' => 'success'])
    {{__('mail.activate')}}
@endcomponent
<center>
    {{__('general.thankYou')}},<br>
    <b> {{ config('app.name') }}</b>
</center>
@endcomponent
