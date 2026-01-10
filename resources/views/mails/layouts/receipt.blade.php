<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>Payment Receipt - {{ config('app.name') }}</title>
    <style>
        /* Reset */
        body, table, td, p, a, li, blockquote {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table, td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        img {
            -ms-interpolation-mode: bicubic;
            border: 0;
            outline: none;
            text-decoration: none;
        }
        
        /* Base Styles */
        body {
            margin: 0 !important;
            padding: 0 !important;
            background-color: #f0f4f8;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        
        /* Wrapper */
        .email-wrapper {
            width: 100%;
            background-color: #f0f4f8;
            padding: 40px 0;
        }
        
        /* Container */
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        /* Header */
        .email-header {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }
        
        .email-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        }
        
        .email-header-icon {
            width: 64px;
            height: 64px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
        }
        
        .email-header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 8px 0;
            text-align: center;
        }
        
        .email-header p {
            color: rgba(255, 255, 255, 0.95);
            font-size: 16px;
            margin: 0;
            text-align: center;
        }
        
        /* Success Badge */
        .success-badge {
            display: inline-block;
            background-color: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-top: 12px;
        }
        
        /* Content */
        .email-content {
            padding: 40px 30px;
        }
        
        .email-content h2 {
            color: #1a202c;
            font-size: 22px;
            font-weight: 600;
            margin: 0 0 24px 0;
            line-height: 1.3;
        }
        
        .email-content h3 {
            color: #2d3748;
            font-size: 18px;
            font-weight: 600;
            margin: 24px 0 12px 0;
        }
        
        .email-content p {
            color: #4a5568;
            font-size: 16px;
            line-height: 1.6;
            margin: 0 0 16px 0;
        }
        
        /* Receipt Box */
        .receipt-box {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 24px;
            margin: 24px 0;
        }
        
        .receipt-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .receipt-item:last-child {
            border-bottom: none;
        }
        
        .receipt-label {
            color: #718096;
            font-size: 14px;
            font-weight: 500;
        }
        
        .receipt-value {
            color: #1a202c;
            font-size: 14px;
            font-weight: 600;
            text-align: right;
        }
        
        .receipt-total {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 2px solid #cbd5e0;
        }
        
        .receipt-total .receipt-label {
            font-size: 18px;
            color: #2d3748;
        }
        
        .receipt-total .receipt-value {
            font-size: 20px;
            color: #48bb78;
        }
        
        /* Table */
        .email-table {
            width: 100%;
            border-collapse: collapse;
            margin: 24px 0;
        }
        
        .email-table th {
            background-color: #f7fafc;
            color: #2d3748;
            font-weight: 600;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #e2e8f0;
            font-size: 14px;
        }
        
        .email-table td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            color: #4a5568;
            font-size: 14px;
        }
        
        .email-table tr:last-child td {
            border-bottom: none;
        }
        
        .email-content a {
            color: #48bb78;
            text-decoration: none;
            font-weight: 500;
        }
        
        .email-content a:hover {
            text-decoration: underline;
        }
        
        /* Button */
        .email-button {
            display: inline-block;
            padding: 14px 32px;
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            text-align: center;
        }
        
        .email-button:hover {
            opacity: 0.9;
        }
        
        /* Divider */
        .email-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e2e8f0, transparent);
            margin: 30px 0;
        }
        
        /* Footer Links */
        .email-footer-links {
            text-align: center;
            padding: 30px 0 20px 0;
            border-top: 1px dashed #cbd5e0;
        }
        
        .email-footer-links a {
            display: inline-block;
            color: #4a5568;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            padding: 0 16px;
            border-right: 1px solid #cbd5e0;
        }
        
        .email-footer-links a:last-child {
            border-right: none;
        }
        
        .email-footer-links a:hover {
            color: #48bb78;
        }
        
        /* Footer Text */
        .email-footer-text {
            padding: 20px 30px 30px 30px;
            background-color: #f7fafc;
            border-top: 1px dashed #cbd5e0;
        }
        
        .email-footer-text p {
            color: #718096;
            font-size: 13px;
            line-height: 1.6;
            margin: 0 0 10px 0;
            text-align: justify;
        }
        
        .email-footer-text a {
            color: #48bb78;
            text-decoration: none;
        }
        
        /* Responsive */
        @media only screen and (max-width: 600px) {
            .email-wrapper {
                padding: 20px 0;
            }
            
            .email-container {
                border-radius: 0;
            }
            
            .email-header {
                padding: 30px 20px;
            }
            
            .email-header h1 {
                font-size: 24px;
            }
            
            .email-content {
                padding: 30px 20px;
            }
            
            .receipt-box {
                padding: 20px;
            }
            
            .receipt-item {
                flex-direction: column;
            }
            
            .receipt-value {
                text-align: left;
                margin-top: 4px;
            }
            
            .email-footer-links a {
                display: block;
                padding: 8px 0;
                border-right: none;
                border-bottom: 1px solid #e2e8f0;
            }
            
            .email-footer-links a:last-child {
                border-bottom: none;
            }
            
            .email-footer-text {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td class="email-wrapper" style="padding: 40px 0;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td align="center">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" class="email-container">
                                <!-- Header -->
                                <tr>
                                    <td class="email-header">
                                        <div class="email-header-icon">✓</div>
                                        <h1>Payment Received</h1>
                                        <p>Thank you for your payment</p>
                                        <span class="success-badge">Transaction Successful</span>
                                    </td>
                                </tr>
                                
                                <!-- Content -->
                                <tr>
                                    <td class="email-content">
                                        @yield('content')
                                    </td>
                                </tr>
                                
                                <!-- Footer Links -->
                                <tr>
                                    <td class="email-footer-links">
                                        <a href="{{ env('APP_URL') }}/en/contact-us" target="_blank">Help & Contact</a>
                                        <a href="{{ env('APP_URL') }}/en/terms-and-conditions" target="_blank">Terms of use</a>
                                        <a href="{{ env('APP_URL') }}/en/coffee-on-the-wall" target="_blank">Coffee on the Wall</a>
                                    </td>
                                </tr>
                                
                                <!-- Footer Text -->
                                <tr>
                                    <td class="email-footer-text">
                                        <p>
                                            Please do not reply to this message; it is an automated email and all replies to it are routed to an unmonitored mailbox. If you have any questions or need assistance, do not hesitate to contact our customer support team at 
                                            <a href="mailto:support@canadianexports.org">support@canadianexports.org</a> 
                                            or call us toll-free at <a href="tel:+18773333014">1-877-333-3014</a>, Monday to Friday, between 9:30am and 5pm EST.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
