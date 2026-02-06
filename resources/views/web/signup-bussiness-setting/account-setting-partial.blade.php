<div class="">
    @php
        $page_id = getLatestRegPageId();
        $user = auth()
            ->guard('customers')
            ->user()
            ->loadMissing(['customerBusinessCategory', 'customerProfile']);
        $customerBusinessCategories = isset($user->customerBusinessCategory) ? $user->customerBusinessCategory->pluck('business_category_id') : null;
    @endphp
    @if (isset($page_name) && $page_name == 'review-confirmation')
        {{-- Review & Confirm: new design - banner, then 1 of 3 Registration Package, 2 of 3 Company & Contact Information, 3 of 3 Business Categories, then Media & Social --}}
        @include('web.signup-bussiness-setting.review-banner')
        @include('web.signup-bussiness-setting.registration-package', ['page_id' => $page_id])
        @include('web.signup-bussiness-setting.company-and-contact-info', ['page_id' => $page_id, 'user' => $user])
        <div class="bg-white py-8 px-4 sm:px-10">
            <h2 class="can-exp-h1 text-center"></h2>
            <business-categories page_id="{{ $page_id }}" profile='1'
                customer_business_categories="{{ $customerBusinessCategories }}"
                user="{{ $user }}"></business-categories>
        </div>
    @elseif (isset($page_name) && $page_name == 'profile-settings')
        {{-- Profile Settings: welcome at very top (same style as in Company & Contact section), then 3-step layout. Description varies by exporter package (Free / Premium / Featured). --}}
        @php
            $regPageSetting = getRegPageSetting();
            $regDetail = $regPageSetting && $regPageSetting->regPageSettingDetail && $regPageSetting->regPageSettingDetail->isNotEmpty()
                ? $regPageSetting->regPageSettingDetail->first()
                : null;
            $greetingText = $regDetail->greeting_text ?? 'Welcome back';
            $packageType = optional($user->registrationPackage)->package_type ?? 'free';
            $profileDescriptions = [
                'free' => 'This is your profile page; you can update your details here or <strong>upgrade your membership</strong> to unlock more features and enhance your visibility. Need help? <strong>Contact us.</strong>',
                'premium' => 'This is your profile page; update your details here or <strong>enhance your visibility</strong> with a Featured plan. Need help? <strong>Contact us.</strong>',
                'featured' => 'Welcome to your <strong>Featured</strong> profile page. You can update your details here or contact us for <strong>priority support.</strong>',
            ];
            $profileDescription = $profileDescriptions[$packageType] ?? $profileDescriptions['free'];
        @endphp
        <div class="bg-white  px-4 sm:px-10  rounded-lg sm:pt-20 w-full max-w-full min-w-0 mt-20">
            <h2 class="font-FuturaMdCnBT  text-gray-900 break-words">{{ $greetingText }} {{ $user->name }},</h2>
            <p class="font-FuturaMdCnBT text-gray-700  break-words whitespace-normal" style="line-height: 1.6; word-wrap: break-word;">{!! $profileDescription !!}</p>
        </div>
        @include('web.signup-bussiness-setting.registration-package', ['page_id' => $page_id])
        @include('web.signup-bussiness-setting.company-and-contact-info', ['page_id' => $page_id, 'user' => $user, 'hide_welcome' => true])
        <div class="bg-white py-8 px-4 sm:px-10">
            <h2 class="can-exp-h1 text-center"></h2>
            <business-categories page_id="{{ $page_id }}" profile='1'
                customer_business_categories="{{ $customerBusinessCategories }}"
                user="{{ $user }}"></business-categories>
        </div>
    @else
        {{-- Legacy layout (other pages) --}}
        @include('web.signup-bussiness-setting.account-setting')
        @include('web.signup-bussiness-setting.registration-package', ['page_id' => $page_id])
        <div class="bg-white py-8 px-4 sm:px-10">
            <h2 class="can-exp-h1 text-center"></h2>
            <business-categories page_id="{{ $page_id }}" profile='1'
                customer_business_categories="{{ $customerBusinessCategories }}"
                user="{{ $user }}"></business-categories>
        </div>
    @endif

    {{-- Step 4 Business Profile: not shown on Review & Confirm or Profile Settings (new 3-step layout) --}}
    @if (!isset($page_name) || ($page_name != 'review-confirmation' && $page_name != 'profile-settings'))
    <div class="bg-white py-8 px-4 sm:px-10">
        <h2 class="can-exp-h1 text-center"></h2>
        <customer-profile page_id="{{ $page_id }}" profile='1'
            user="{{ auth()->guard('customers')->user()->loadMissing('customerProfile') }}"></customer-profile>
    </div>
    @endif

    <div class="">
        <div class="bg-white py-8 px-4 sm:px-10">
            <h2 class="can-exp-h1"></h2>
            @php
                $customer = getCustomerResource();
            @endphp
            <customer-media page_id="{{ $page_id }}" profile='1'
                user="{{ json_encode($customer) }}"></customer-media>
        </div>

        <div class="">
            <div class="bg-white py-8 px-4 sm:px-10">
                @if (!isset($hideProcessBtn))
                    @php
                        $hideProcessBtn = 'no';
                    @endphp
                @endif
                @php
                    $payment_setting = getI2bModalSetting(null, ['payment_setting']);
                    $url = langBasedURL(null, route('user.profile-settings.index'));
                @endphp
                <h2 class="can-exp-h1 text-center"></h2>
                <social-media page_id="{{ $page_id }}" profile='1'
                    user="{{ auth()->guard('customers')->user()->loadMissing('customerSocialMedia') }}"
                    hide_process_btn="{{ $hideProcessBtn }}" payment_setting="{{ $payment_setting }}"
                    url="{{ $url }}">
                </social-media>
            </div>
        </div>
    </div>
</div>
