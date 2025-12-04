{{-- @component('mail::message')
Hello,

<p style="text-align: justify;">My name is: {{ $data['name'] }}</p>
<p style="text-align: justify;">My email id is: {{ $data['email'] }}</p>
<p style="text-align: justify;">My company name is: {{ $data['company_name'] }}</p>
@if(isset($data['signup_page']) && $data['signup_page'] == 'event')
@else
<p style="text-align: justify;">I registered under the following business categories:
@foreach($data['business_categories_name'] as $business_categories_name)
@if ($loop->last)
<strong>"{{$business_categories_name}}"</strong>
@else
<strong>"{{$business_categories_name}}"</strong>,
@endif
@endforeach
</p>

@endif
@if(isset($data['signup_page']) && $data['signup_page'] == 'event')
@php
$price = $data['package_price'];
@endphp
@else
@if($data['payment_frequency'] == 'monthly')
@php
$price = $data['package_price'];
@endphp
@elseif($data['payment_frequency'] == 'quarterly')
@php
$price = $data['package_price']*3;
@endphp
@elseif($data['payment_frequency'] == 'semi_annually')
@php
$price = $data['package_price']*6;
@endphp
@elseif($data['payment_frequency'] == 'annually')
@php
$price = $data['package_price']*12;
@endphp
@endif
@endif
<p style="text-align: justify;">Selected registration package: ${{ isset($price) ? number_format($price, 2) : number_format(0, 2) }}</p>
<p style="text-align: justify;">and i have completed registration with Canadian Exports on {{ $data['created_at'] }}</p>
@php
$encyrtedEmail = str_replace('/', '===', $data['user_id']);
@endphp --}}
{{-- <x-mail::button :url="route('front.update-new-user-status', ['email' => $data['email'], 'id' => $encyrtedEmail, 'status' => 'active'])" color="success">
Activate user
</x-mail::button> --}}


{{-- {{ config('app.name') }} --}}

{{-- @endcomponent --}}


@component('mail::message')
<p style="text-align: justify;">A new user registered an exporter profile on the Canadian Exports website with the following details:</p>

<p style="text-align: justify;">Company name: {{ $data['company_name'] }}</p>
<p style="text-align: justify;">Contact person’s name: {{ $data['name'] }}</p>
<p style="text-align: justify;">Email: {{ $data['email'] }}</p>
<p style="text-align: justify;">Date of registration: {{ \Carbon\Carbon::parse($data['created_at'])->format('F d, Y') }}</p>
@if(isset($data['signup_page']) && $data['signup_page'] == 'event')
  @php
    $price = $data['package_price'];
  @endphp
@else
  @if($data['payment_frequency'] == 'monthly')
    @php $price = $data['package_price']; @endphp
  @elseif($data['payment_frequency'] == 'quarterly')
    @php $price = $data['package_price'] * 3; @endphp
  @elseif($data['payment_frequency'] == 'semi_annually')
    @php $price = $data['package_price'] * 6; @endphp
  @elseif($data['payment_frequency'] == 'annually')
    @php $price = $data['package_price'] * 12; @endphp
  @endif
@endif

<p><strong>Price:</strong> ${{ isset($price) ? number_format($price, 2) : number_format(0, 2) }}</p>

@if(isset($data['signup_page']) && $data['signup_page'] != 'event')
<p><strong>Registered under these business categories:</strong></p>
@foreach($data['business_categories_name'] as $business_category)
<p> - <strong>{{ $business_category }}</strong></p>
@endforeach
@endif

<p><strong>Membership package:</strong> {{ ucfirst($data['package']['package_type'] ?? 'Free') }}</p>
<p><strong>Membership duration:</strong> {{ ucfirst(str_replace('_', ' ', $data['payment_frequency'] ?? 'Not specified')) }}</p>

@php
  $encryptedEmail = str_replace('/', '===', $data['user_id']);
@endphp

{{-- Uncomment this if activation button is needed --}}
{{-- <x-mail::button :url="route('front.update-new-user-status', ['email' => $data['email'], 'id' => $encryptedEmail, 'status' => 'active'])" color="success">
Activate User
</x-mail::button> --}}

@endcomponent
