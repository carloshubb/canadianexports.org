<div class="">
    @php
        $sponsorUser = auth()->guard('customers')->user();
        $abbr = strtolower(trim(($lang ?? null)?->abbreviation ?? app()->getLocale() ?? 'en'));
        $locale = (in_array($abbr, ['es', 'esp', 'spa', 'sp']) || str_starts_with($abbr, 'es') || str_starts_with($abbr, 'sp')) ? 'es' : 'en';
        App::setLocale($locale);
        $sponsorGreeting = __('Welcome back');
        $sponsorDescription = __('Welcome to your <strong>Sponsor Dashboard</strong>. We are honored to have your support. You can update your recognition details here, or contact your dedicated account manager for any <strong>priority assistance</strong>. Thank you for being a <strong>cornerstone of Canadian Exports.</strong>');
    @endphp
    <div class="bg-white  px-4 sm:px-10  rounded-lg sm:pt-20 w-full max-w-full min-w-0 mt-20">
        <h2 class="font-FuturaMdCnBT  text-gray-900 break-words">{{ $sponsorGreeting }} {{ $sponsorUser->name ?? '' }},</h2>
        <p class="font-FuturaMdCnBT text-gray-700  break-words whitespace-normal" style="line-height: 1.6; word-wrap: break-word;">{!! $sponsorDescription !!}</p>
    </div>
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
