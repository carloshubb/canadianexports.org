{{-- Membership Notice: Event Posting modal for Free exporters. Include with @include('front.pages.partials.membership-notice-event-posting-modal', ['eventSignupUrl' => $eventSignupUrl]) --}}
<div id="membership-notice-event-posting-modal"
    class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center"
    role="dialog"
    aria-modal="true"
    aria-labelledby="membership-notice-modal-title"
    onclick="if (event.target === this) window.closeMembershipNoticeEventPostingModal();">
    <div class="membership-notice-modal-content gradient-border-modal rounded-lg p-6 max-w-lg w-full mx-4" onclick="event.stopPropagation();">
        <h2 id="membership-notice-modal-title" class="font-FuturaMdCnBT text-primary text-xl md:text-2xl mb-4 text-center">
            Membership Notice: Event Posting
        </h2>
        <div class="space-y-4 text-gray-700 text-base leading-relaxed">
            <p>
                Please note that while <strong>Premium</strong> and <strong>Featured</strong> Members enjoy complimentary <strong>Premium Event</strong> listings, your current <strong>Free</strong> plan requires a per-post fee.
            </p>
            <p>
                You may <strong>upgrade your membership</strong> to unlock free event credits, or <strong>proceed below</strong> to create your event as a paid listing.
            </p>
            <p class="text-sm">
                (Note: <strong>Featured Events</strong> remain a paid upgrade for all membership tiers.)
            </p>
        </div>
        <div class="mt-6  rounded-lg p-4">
            <div class="flex flex-wrap gap-3 justify-center">
                <button type="button"
                    onclick="window.closeMembershipNoticeEventPostingModal();"
                    class="button-exp-no-fill px-4 py-2">
                    Close
                </button>
                <a href="{{ $eventSignupUrl ?? '#' }}" class="button-exp-fill px-4 py-2 inline-flex items-center justify-center">
                    Proceed to Create Event
                </a>
            </div>
        </div>
    </div>
</div>
@section('scripts')
@parent
<script>
(function() {
    window.openMembershipNoticeEventPostingModal = function() {
        var el = document.getElementById('membership-notice-event-posting-modal');
        if (el) {
            el.classList.remove('hidden');
            el.classList.add('flex');
        }
    };
    window.closeMembershipNoticeEventPostingModal = function() {
        var el = document.getElementById('membership-notice-event-posting-modal');
        if (el) {
            el.classList.add('hidden');
            el.classList.remove('flex');
        }
    };
})();
</script>
@endsection