<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $title ?? 'OTP Verification Code' }}</title>
    <style type="text/css">
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
        
        @media only screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                max-width: 100% !important;
                padding: 20px 10px !important;
            }
            .email-card {
                width: 100% !important;
                max-width: 100% !important;
                border-radius: 0 !important;
            }
            .main-padding {
                padding: 20px 20px !important;
            }
            .banner-padding {
                padding: 25px 20px !important;
            }
            .banner-title {
                font-size: 32px !important;
            }
            .banner-subtitle {
                font-size: 14px !important;
            }
            .banner-icon {
                width: 70px !important;
                height: 70px !important;
            }
            .banner-icon div {
                font-size: 32px !important;
            }
            .content-heading {
                font-size: 24px !important;
            }
            .content-text {
                font-size: 15px !important;
            }
            .otp-code {
                font-size: 32px !important;
                letter-spacing: 6px !important;
            }
            .footer-padding {
                padding: 30px 20px !important;
            }
            .social-icon {
                width: 36px !important;
                height: 36px !important;
                line-height: 36px !important;
            }
            .social-icon span {
                font-size: 16px !important;
            }
        }
        
        @media only screen and (max-width: 480px) {
            .banner-title {
                font-size: 28px !important;
            }
            .content-heading {
                font-size: 22px !important;
            }
            .otp-code {
                font-size: 28px !important;
                letter-spacing: 4px !important;
            }
        }
    </style>
    <!--[if mso]>
    <style type="text/css">
        table {border-collapse:collapse;border-spacing:0;margin:0;}
        div, td {padding:0;}
        div {margin:0 !important;}
    </style>
    <![endif]-->
</head>
<body style="margin: 0; padding: 0; background-color: #FFFFFF; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;">
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" class="email-container" style="background-color: #FFFFFF; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" class="email-card" style="max-width: 600px; width: 100%; background-color: #FFFFFF; border-radius: 16px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); overflow: hidden;">
                    
                    <!-- Logo Section -->
                    <tr>
                        <td align="center" style="padding: 20px 30px 15px 30px;">
                            <img src="{{ env('APP_URL') }}/img/logo2.png" alt="SimPlug Logo" style="max-width: 180px; height: auto; display: block; border: 0;" />
                        </td>
                    </tr>
                    
                    <!-- Banner Section -->
                    <tr>
                        <td>
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background: #1812AE; border-radius: 0;">
                                <tr>
                                    <td class="banner-padding" style="padding: 30px 30px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td width="60%" valign="middle" style="width: 60%;">
                                                    <h1 class="banner-title" style="margin: 0; color: #FFFFFF; font-size: 42px; font-weight: 700; line-height: 1.2; letter-spacing: -1px;">OTP Code</h1>
                                                    <p class="banner-subtitle" style="margin: 8px 0 0 0; color: #FFFFFF; font-size: 16px; opacity: 0.95; font-weight: 400;">Security verification</p>
                                                </td>
                                                <td width="40%" align="right" valign="middle" style="width: 40%;">
                                                    <div class="banner-icon" style="width: 90px; height: 90px; background-color: rgba(255, 255, 255, 0.15); border-radius: 50%; display: inline-block; position: relative;">
                                                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #FFFFFF; font-size: 40px;">🔐</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Main Content Section -->
                    <tr>
                        <td class="main-padding" style="padding: 40px 30px;">
                            <h2 class="content-heading" style="margin: 0 0 12px 0; color: #2C2C2C; font-size: 28px; font-weight: 700; line-height: 1.3;">{{ $title ?? 'Your Verification Code' }}</h2>
                            @if(isset($name))
                            <p class="content-text" style="margin: 0 0 24px 0; color: #4A4A4A; font-size: 16px; line-height: 1.6;">Hello, <strong style="color: #1812AE;">{{ $name }}</strong>,</p>
                            @endif
                            
                            <p class="content-text" style="margin: 0 0 20px 0; color: #4A4A4A; font-size: 16px; line-height: 1.6;">
                                {{ $description ?? "You're attempting to access your SimPlug account. To complete verification, use the following one-time code (OTP):" }}
                            </p>
                            
                            <!-- OTP Code Display -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <div style="background: #F5F5F5; border: 2px dashed #1812AE; border-radius: 12px; padding: 32px 24px; margin: 20px 0;">
                                            <p style="margin: 0 0 12px 0; color: #1812AE; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px;">Your Verification Code</p>
                                            <div class="otp-code" style="font-size: 42px; font-weight: 700; color: #1812AE; letter-spacing: 10px; font-family: 'Courier New', monospace; margin: 12px 0; text-align: center;">{{ $otp }}</div>
                                            <p style="margin: 12px 0 0 0; color: #1812AE; font-size: 13px; font-weight: 500;">⏱️ Valid for {{ $validityTime ?? '10' }} minutes</p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Security Notice -->
                            <div style="background-color: #d9d9f3d1; border-left: 4px solid #1812AE; padding: 16px; border-radius: 4px; margin: 24px 0;">
                                <p style="margin: 0; color: #4A4A4A; font-size: 14px; line-height: 1.5;">
                                    <strong>⚠️ Security Important:</strong> {{ $footer ?? "If you didn't request this code, ignore this email or contact our support team immediately. Never share this code with anyone, even if they claim to be from SimPlug." }}
                                </p>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Footer Section -->
                    <tr>
                        <td class="footer-padding" style="padding: 40px 30px; background-color: #FFFFFF; border-top: 2px solid #F0F0F0;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                <!-- Contact Information -->
                                <tr>
                                    <td align="center" style="padding-bottom: 24px;">
                                        <p style="margin: 0 0 8px 0; color: #4A4A4A; font-size: 14px; line-height: 1.6;">
                                            Questions or concerns? Get in touch with us at
                                        </p>
                                        <p style="margin: 0; color: #4A4A4A; font-size: 14px; line-height: 1.6;">
                                            <a href="mailto:{{ 'support@SimPlug.com.ng' }}" style="color: #1812AE; text-decoration: none; font-weight: 500;">{{ 'support@SimPlug.com.ng' }}</a>
                                            @if(isset($supportPhone))
                                            or <a href="tel:{{ $supportPhone }}" style="color: #1812AE; text-decoration: none; font-weight: 500;">{{ $supportPhone }}</a>
                                            @endif
                                        </p>
                                    </td>
                                </tr>
                                
                                <!-- Copyright -->
                                <tr>
                                    <td align="center" style="padding-bottom: 24px;">
                                        <p style="margin: 0; color: #4A4A4A; font-size: 12px; line-height: 1.6;">
                                            Copyright © {{ date('Y') }} SimPlug. All rights reserved.
                                        </p>
                                    </td>
                                </tr>
                                
                                <!-- Brand Logo -->
                                <!-- <tr>
                                    <td align="center" style="padding-top: 20px; border-top: 1px solid #F0F0F0;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: 0 auto;">
                                            <tr>
                                                <td align="center" style="padding: 20px 0;">
                                                    <img src="{{ $logoUrl ?? asset('images/SimPlug-logo.png') }}" alt="SimPlug Logo" style="max-width: 150px; height: auto; display: block; border: 0;" />
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr> -->
                            </table>
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
