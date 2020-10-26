@component('mail::message')
    ## Message from {{$email->email}}

    {{ $email->message }}

    Thanks,<br>
    {{$email->name}} ({{ config('app.name') }})
@endcomponent
