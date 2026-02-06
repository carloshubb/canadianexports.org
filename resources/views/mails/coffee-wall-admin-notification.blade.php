@component('mail::message')

# Coffee on the Wall – New Donation

A new Coffee on the Wall has been added. Details below.

---

## Frequency
{{ $coffeeWallet->frequency ? ucfirst(strtolower($coffeeWallet->frequency)) : 'One-time' }}

## Amount
${{ number_format((float) $coffeeWallet->dr_amount, 2) }}

## Beneficiary / Beneficiaries
@if($coffeeWallet->beneficiaries && $coffeeWallet->beneficiaries->isNotEmpty())
@foreach($coffeeWallet->beneficiaries as $b)
- {{ $b->name }}
@endforeach
@else
—
@endif

## Contact details (donor)
| Field | Value |
|-------|--------|
| Name | {{ $coffeeWallet->anonymous ? 'Anonymous' : ($coffeeWallet->name ?? '—') }} |
| Email | {{ $coffeeWallet->anonymous ? 'Hidden (anonymous)' : ($coffeeWallet->email ?? '—') }} |
| Phone | {{ $coffeeWallet->anonymous ? 'Hidden (anonymous)' : ($coffeeWallet->phone ?? '—') }} |

## Options
- **Anonymous donation:** {{ $coffeeWallet->anonymous ? 'Yes' : 'No' }}
- **Notify when coffee is used:** {{ $coffeeWallet->notify_when_used ? 'Yes' : 'No' }}

## Payment
- **Method:** {{ $coffeeWallet->payment_method ? ucfirst($coffeeWallet->payment_method) : 'Free / No payment' }}
- **Status:** {{ $coffeeWallet->status ?? '—' }}

## Package
@if($coffeeWallet->package)
- Package ID: {{ $coffeeWallet->package->id }}
- Amount: ${{ number_format((float) ($coffeeWallet->package->price ?? $coffeeWallet->dr_amount), 2) }}
@else
- Custom or one-off amount: ${{ number_format((float) $coffeeWallet->dr_amount, 2) }}
@endif

## Date added
{{ $coffeeWallet->created_at ? $coffeeWallet->created_at->format('F j, Y \a\t g:i A') : '—' }}

---

This is an automated notification. No reply is required.

@endcomponent
