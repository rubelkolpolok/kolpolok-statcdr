@component('mail::message')
# Dear Partner

This is {{Auth::user()->name}} from Shell Voice. We are currently interconnecting with bellow company and they gave your details in their Official Credit Reference form.
We would be appreciate if you could help to make a trade reference for this company. Thank you for sparing time to fill bellow details.

Credit Enquiry for:Kolpolok Limited

Your Name: {{$reference->name}}

Agreement Type with above company (Unilateral / Bilateral):
How long have you been doing business with them(In Years):
What type of payment you allow them(Pre-Pay/Post-Pay):
If post pay, how much credit limit you offered them(in USD):
What is the billing circle:
Is there any late payment record:
Is there any disputes record:
Is there any comments you want to share:

Thanks,<br>
{{ config('app.name') }}
@endcomponent
