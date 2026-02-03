{{-- New design: "2 of 3 - Company & Contact Information" (same as Signup.vue CompanyAndContactInfo) --}}
<div class="bg-white py-8 px-4 sm:px-10">
    <h2 class="can-exp-h1 text-center"></h2>
    @php
        $lang = getDefaultLanguage(true);
        $user_for_company = isset($user) ? $user : auth()->guard('customers')->user()->loadMissing('customerProfile');
    @endphp
    <company-and-contact-info profile="1" :user='@json($user_for_company)' :page_id="{{ json_encode($page_id ?? getLatestRegPageId()) }}" :lang='@json($lang)'></company-and-contact-info>
</div>
