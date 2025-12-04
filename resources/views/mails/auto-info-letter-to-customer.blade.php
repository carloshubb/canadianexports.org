@component('mail::message')
Hello,
<p style="text-align: justify;">We are excited to announce the release of several new features that will enhance your experience with our platform. These features are designed to provide greater flexibility and efficiency in managing your tasks.</p>

# Details:

<ul>
    <li><strong>What’s changing:</strong> We are introducing a new dashboard layout, advanced reporting tools, and improved security measures.</li>
    <li><strong>Why it’s changing:</strong> These updates are part of our commitment to continuously improve our services and provide you with the best possible experience.</li>
    <li><strong>When it’s changing:</strong> The new features will be available starting June 20, 2024.</li>
</ul>

<p style="text-align: justify;">Thank you for your attention to this update. We appreciate your continued support and look forward to providing you with enhanced services.</p>

# Thank you,<br>
# Canadian Exports Team
@isset($data['subscribe_hash'])
<x-mail::footer>
<p style="text-align: justify;">we'll only send you valueable information that you won't find anywhere else, but if you're not intrested, please <a href="{{route('front.confirm-unsubscribe', ['q' => $data['subscribe_hash']])}}">click here to unsubscribe</a>.</p>
</x-mail::footer>
@endisset
@endcomponent
