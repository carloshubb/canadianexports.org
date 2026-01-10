@extends('mails.layouts.regular')

@section('content')
    <h2>Hello {{ $data["name"] }},</h2>
    
    <p>Please find below the details on the Inquiries to buy that you asked for.</p>
    
    <h3>Inquiry Details:</h3>
    <ul>
        <li><strong>Business Category:</strong> {{ $data["business_category"] }}</li>
        <li><strong>Deadline Date:</strong> {{ $data["deadline_date"] }}</li>
        <li><strong>Estimated Value:</strong> {{ $data["estimated_value"] }}</li>
    </ul>
    
    @if(!empty($data['inquiry_details']))
    <h3>Inquiry Contacts:</h3>
    <ul>
        @foreach(collect($data['inquiry_details'])->filter(fn($detail) => !empty($detail['name']) && $detail['name'] !== 'N/A')->all() as $detail)
        <li>
            <strong>Name:</strong> {{ $detail['name'] }}<br>
            <strong>Country:</strong> {{ $detail['country'] }}
        </li>
        @endforeach
    </ul>
    @endif
    
    @if(!empty($data['pdf_download_links']) && count($data['pdf_download_links']) > 0)
    <h3>Download Documents:</h3>
    <p>Click the links below to download the PDF documents related to this inquiry:</p>
    @foreach($data['pdf_download_links'] as $pdfKey => $downloadLink)
        @php
            $pdfNumber = str_replace('pdf_', 'Document ', $pdfKey);
        @endphp
        <p>
            <a href="{{ $downloadLink }}" class="email-button">Download {{ $pdfNumber }}</a>
        </p>
    @endforeach
    <p style="font-size: 14px; color: #718096; margin-top: 12px;">
        <em>Note: Download links expire in 7 days. Please download the documents promptly.</em>
    </p>
    @endif
    
    <p>We wish you success in your business. If you need further assistance, feel free to contact us anytime.</p>
    
    <p><strong>Note:</strong> If you believe this email has reached you in error, please disregard it. Your information will remain secure.</p>
    
    <p>Thank you and have a good day!</p>
    
    <p><strong>Canadian Exports Team</strong></p>
@endsection
