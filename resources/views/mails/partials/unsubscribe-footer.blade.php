@if(isset($unsubscribeLink) && $unsubscribeLink)
<div style="margin-top: 24px; padding-top: 16px; border-top: 1px dashed #cccccc;">
    <p style="text-align: center; color: #666666; font-size: 12px; line-height: 18px; margin: 0;">
        You are receiving this email because you are registered or subscribed to Canadian Exports.<br>
        If you no longer wish to receive emails from us, you can 
        <a href="{{ $unsubscribeLink }}" style="color: #2563eb; text-decoration: underline;">unsubscribe here</a>.
    </p>
</div>
@endif

