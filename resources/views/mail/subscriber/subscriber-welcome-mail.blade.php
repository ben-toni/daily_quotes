@component('mail::message')
<center>
    {{__('general.welcome')}}
    <br>
    {{__('mail.activatedAcc')}}
    <br>
    {{__('mail.receiveQuotesDesc')}}
</center>
@component('mail::button', ['url' =>  $url, 'color' => 'success'])
    {{__('mail.deactivate')}}
@endcomponent
<center>
    {{__('general.thankYou')}},<br>
    <b> {{ config('app.name') }}</b>
</center>
@endcomponent
