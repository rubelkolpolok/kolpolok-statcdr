@component('mail::message')
# Dear Partner

We received your information, Now we will verify your busines. Please send your Trade reference.

@component('mail::button', ['url' => route('agreement.edit',$agreement->id)])
Trade Reference
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
