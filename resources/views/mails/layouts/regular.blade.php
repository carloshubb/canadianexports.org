<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>{{ config('app.name') }}</title>
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
            background-color: #f5f7fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        
        /* Wrapper */
        .email-wrapper {
            width: 100%;
            background-color: #f5f7fa;
            padding: 40px 0;
        }
        
        /* Container */
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        }
        
        /* Header */
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
        }
        
        .email-header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            text-align: center;
        }
        
        /* Content */
        .email-content {
            padding: 40px 30px;
        }
        
        .email-content h2 {
            color: #1a202c;
            font-size: 24px;
            font-weight: 600;
            margin: 0 0 20px 0;
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
        
        .email-content ul, .email-content ol {
            color: #4a5568;
            font-size: 16px;
            line-height: 1.8;
            margin: 16px 0;
            padding-left: 24px;
        }
        
        .email-content li {
            margin-bottom: 8px;
        }
        
        .email-content a {
            color: #667eea;
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            color: #667eea;
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
            color: #667eea;
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
            
            .email-content h2 {
                font-size: 20px;
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
                                        <h1>{{ config('app.name') }}</h1>
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
