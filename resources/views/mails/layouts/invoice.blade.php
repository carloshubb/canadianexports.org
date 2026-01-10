<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>Invoice - {{ config('app.name') }}</title>
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        /* Header */
        .email-header {
            background: linear-gradient(135deg, #3182ce 0%, #2c5282 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }
        
        .email-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #4299e1, #3182ce, #2c5282);
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
        
        /* Invoice Badge */
        .invoice-badge {
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
        
        /* Invoice Box */
        .invoice-box {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            border: 2px solid #cbd5e0;
            border-radius: 8px;
            padding: 24px;
            margin: 24px 0;
        }
        
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .invoice-info {
            flex: 1;
        }
        
        .invoice-info h3 {
            color: #2d3748;
            font-size: 18px;
            font-weight: 700;
            margin: 0 0 8px 0;
        }
        
        .invoice-info p {
            color: #718096;
            font-size: 14px;
            margin: 4px 0;
        }
        
        .invoice-number {
            text-align: right;
        }
        
        .invoice-number .invoice-label {
            color: #718096;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        
        .invoice-number .invoice-value {
            color: #3182ce;
            font-size: 20px;
            font-weight: 700;
        }
        
        /* Invoice Items */
        .invoice-items {
            margin: 24px 0;
        }
        
        .invoice-item {
            display: flex;
            justify-content: space-between;
            padding: 16px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .invoice-item:last-child {
            border-bottom: none;
        }
        
        .invoice-item-label {
            color: #4a5568;
            font-size: 15px;
            font-weight: 500;
            flex: 1;
        }
        
        .invoice-item-value {
            color: #1a202c;
            font-size: 15px;
            font-weight: 600;
            text-align: right;
            min-width: 120px;
        }
        
        /* Invoice Totals */
        .invoice-totals {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 2px solid #cbd5e0;
        }
        
        .invoice-total-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
        }
        
        .invoice-total-label {
            color: #2d3748;
            font-size: 16px;
            font-weight: 600;
        }
        
        .invoice-total-value {
            color: #3182ce;
            font-size: 18px;
            font-weight: 700;
        }
        
        .invoice-total-row.grand-total .invoice-total-label {
            font-size: 18px;
            color: #1a202c;
        }
        
        .invoice-total-row.grand-total .invoice-total-value {
            font-size: 24px;
            color: #2c5282;
        }
        
        /* Table */
        .email-table {
            width: 100%;
            border-collapse: collapse;
            margin: 24px 0;
            background-color: #ffffff;
        }
        
        .email-table th {
            background: linear-gradient(135deg, #edf2f7 0%, #e2e8f0 100%);
            color: #2d3748;
            font-weight: 600;
            padding: 14px;
            text-align: left;
            border-bottom: 2px solid #cbd5e0;
            font-size: 14px;
        }
        
        .email-table td {
            padding: 14px;
            border-bottom: 1px solid #e2e8f0;
            color: #4a5568;
            font-size: 14px;
        }
        
        .email-table tr:last-child td {
            border-bottom: none;
        }
        
        .email-table tr:nth-child(even) {
            background-color: #f7fafc;
        }
        
        .email-content a {
            color: #3182ce;
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
            background: linear-gradient(135deg, #3182ce 0%, #2c5282 100%);
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
            color: #3182ce;
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
            color: #3182ce;
            text-decoration: none;
        }
        
        /* Note Box */
        .invoice-note {
            background-color: #fff5e6;
            border-left: 4px solid #f6ad55;
            padding: 16px;
            margin: 24px 0;
            border-radius: 4px;
        }
        
        .invoice-note p {
            color: #744210;
            font-size: 14px;
            margin: 0;
            line-height: 1.6;
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
            
            .invoice-box {
                padding: 20px;
            }
            
            .invoice-header {
                flex-direction: column;
            }
            
            .invoice-number {
                text-align: left;
                margin-top: 16px;
            }
            
            .invoice-item {
                flex-direction: column;
            }
            
            .invoice-item-value {
                text-align: left;
                margin-top: 4px;
            }
            
            .invoice-total-row {
                flex-direction: column;
            }
            
            .invoice-total-value {
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
                                        <h1>Invoice</h1>
                                        <p>{{ config('app.name') }}</p>
                                        <span class="invoice-badge">Official Document</span>
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
