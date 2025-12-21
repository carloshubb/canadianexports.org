<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Question Was Answered</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #7c3aed; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9fafb; padding: 30px; border: 1px solid #e5e7eb; }
        .question-box { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #7c3aed; }
        .answer-box { background: #ede9fe; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #7c3aed; }
        .label { font-weight: bold; color: #6b7280; font-size: 14px; margin-bottom: 8px; }
        .footer { text-align: center; padding: 20px; color: #6b7280; font-size: 14px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Your Question Was Answered!</h1>
    </div>
    
    <div class="content">
        <p>Hello {{ $question->asker_name }},</p>
        
        <p>Great news! Your question for the webinar "<strong>{{ $webinar->title }}</strong>" has been answered by the presenter.</p>
        
        <div class="question-box">
            <div class="label">Your Question:</div>
            <p style="margin: 0;">{{ $question->question }}</p>
        </div>
        
        @if($question->answer)
        <div class="answer-box">
            <div class="label">Answer:</div>
            <p style="margin: 0;">{{ $question->answer }}</p>
        </div>
        @else
        <p><em>This question was answered live during the webinar.</em></p>
        @endif
        
        <p>Thank you for participating in our Q&A!</p>
        
        <p>Best regards,<br>The Canadian Exports Team</p>
    </div>
    
    <div class="footer">
        <p>You received this email because you asked a question for a webinar on our website.</p>
    </div>
</body>
</html>

