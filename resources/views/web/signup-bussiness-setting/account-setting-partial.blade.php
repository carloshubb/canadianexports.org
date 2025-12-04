<div class="">
    @if (isset($page_name) && $page_name == 'review-confirmation')
        @include('web.signup-bussiness-setting.review-banner')
        @include('web.signup-bussiness-setting.registration-package')
        @include('web.signup-bussiness-setting.account-setting')
    @else
        @include('web.signup-bussiness-setting.account-setting')
        @include('web.signup-bussiness-setting.registration-package')
    @endif

    <div class="bg-white py-8 px-4 sm:px-10">
        <h2 class="can-exp-h1 text-center"></h2>
        @php
            $page_id = getLatestRegPageId();
            $user = auth()
                ->guard('customers')
                ->user()
                ->loadMissing('customerBusinessCategory');
            $customerBusinessCategories = isset($user->customerBusinessCategory) ? $user->customerBusinessCategory->pluck('business_category_id') : null;
        @endphp
        <business-categories page_id="{{ $page_id }}" profile='1'
            customer_business_categories="{{ $customerBusinessCategories }}"
            user="{{ $user }}"></business-categories>
    </div>

    <div class="bg-white py-8 px-4 sm:px-10">
        <h2 class="can-exp-h1 text-center"></h2>
        <customer-profile page_id="{{ $page_id }}" profile='1'
            user="{{ auth()->guard('customers')->user()->loadMissing('customerProfile') }}"></customer-profile>
    </div>

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
