@component('mail::message')
<center>
    {{$quote->description}}
</center>
@component('mail::button', ['url' => config('app.url').'/status/subscribers/'.$subscriber->id, 'color' => 'success'])
    {{__('mail.deactivate')}}
@endcomponent
<center>
    {{__('general.thankYou')}},<br>
    <b> {{ config('app.name') }}</b>
</center>
@endcomponent
