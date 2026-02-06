<div class="">
    <div class="bg-white mt-10 py-8 px-4 sm:px-10">
        @php
            $langAbbr = app()->getLocale() ?? 'en';
            $becomeSponsorSlug = "$langAbbr/user/sponsor-settings/add";
            $sponsorSettingsSlug = "$langAbbr/user/sponsor-settings";
            $loggedInUser = auth()->guard('customers')->user();
        @endphp
        <sponsor-management 
            become-sponsor-slug="{{ $becomeSponsorSlug }}"
            sponsor-settings-slug="{{ $sponsorSettingsSlug }}"
            :logged-in-user="{{ $loggedInUser ? json_encode($loggedInUser) : 'null' }}"
        ></sponsor-management>
    </div>
</div>
