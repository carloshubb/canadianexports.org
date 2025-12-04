<div class="bg-white py-8 px-4 sm:px-10">
    <h2 class="can-exp-h1 text-center"></h2>
    @php
        $page_id = getLatestRegPageId();
        $user = getCustomerResourceWithProfileImage();
        $user->package_expiry_date = date('m/d/Y', strtotime($user->package_expiry_date));
    @endphp
    @if (session('status'))
        <success-message type="{{ session('status') }}" message="{{ session('message') }}"></success-message>
    @endif
    <user-profile page_id="{{ $page_id }}" profile='1' user="{{ json_encode($user) }}"></user-profile>
</div>
