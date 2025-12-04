@component('mail::message')
## From {{$data["data"]["name"]." (".$data["data"]["email"]}})
# Dear {{$data['event']["contact_name"]}},
<p>Could you please provide information regarding stand availability, pricing, and any specific requirements for exhibitors?</p>


Thanks,<br>
{{-- {{ config('app.name') }} --}}
@endcomponent
