@extends('front.layouts.app')
@section('title', 'Canadian Exports | Complete your pending payment')
@section('meta_description',
    'Canadian Exports is a Canadian export portal and a directory of Canadian exporters,
    showcasing lists of Canadian products and services, and promoting Canadian manufacturers and exporters. Canadian Exports
    is a Canadian business directory and a Canadian business database highlighting the Canadian industry')
@section('Canadian Export, Export from Canada, Canada export, Export Canada, Exporting from Canada, Canada export
    catalogue, Canada export directory, Directory of, Canadian exporters, Canada business directory, Directory of Canadian
    companies, Directory of Canadian companies, Canada trade, Canadian trade, Canada export portal, Canada trade mission')
@section('content')
    <div class="relative md:py-16 py-8 container mx-auto">
        @php
            $user = auth()
                ->guard('customers')
                ->user()
                ->loadMissing('registrationPackage')
                ->loadMissing('customerProfile');
            $lang = getDefaultLanguage(true);
            $url = langBasedURL($lang, route('front.index', $lang->abbreviation));
            $package_detail = getPackageDetail($user->registration_package_id, $lang);
            $payment_setting = getI2bModalSetting($lang, ['payment_setting']);
            $isPaid = $user && $user->is_package_amount_paid == 1;
        @endphp
        @if ($isPaid)
            <script>
                window.location.href = "{{ $url }}";
            </script>
        @else
            @if ($user->type == 'event')
                @include('web.signup-bussiness-setting.event-account-setting-partial', [
                    'hideProcessBtn' => 'yes',
                    'page_name' => 'review-confirmation',
                    'payment_setting' => $payment_setting,
                ])
            @else
                @include('web.signup-bussiness-setting.account-setting-partial', [
                    'hideProcessBtn' => 'yes',
                    'page_name' => 'review-confirmation',
                    'payment_setting' => $payment_setting,
                ])
                <create-profile-payment url="{{ $url }}" user="{{ $user }}"
                    package_detail="{{ $package_detail }}" payment_setting="{{ $payment_setting }}"></create-profile-payment>
            @endif
        @endif
        <script>
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    window.location.reload();
                }
            });
        </script>
    </div>
@endsection
