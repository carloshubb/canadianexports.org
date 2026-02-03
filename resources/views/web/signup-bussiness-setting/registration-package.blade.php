<div class="bg-white py-8 px-4 sm:px-10">
    {{-- <h2 class="can-exp-h1 text-center"></h2> --}}
    @php
        $payment_setting = getI2bModalSetting(null, ['payment_setting']);
        $user = auth()
            ->guard('customers')
            ->user()
            ->loadMissing('registrationPackage');
        $reg_page_id = $page_id ?? getLatestRegPageId();
    @endphp
    <registration-package profile='1' user="{{ $user }}" payment_setting="{{ $payment_setting }}" :page_id="{{ json_encode($reg_page_id) }}"></registration-package>
</div>
