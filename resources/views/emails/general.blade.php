<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $subject ?? 'SimPlug' }}</title>
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
                    @if(isset($bannerTitle) || isset($bannerSubtitle))
                    <tr>
                        <td>
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background: #1812AE; border-radius: 0;">
                                <tr>
                                    <td class="banner-padding" style="padding: 30px 30px;">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td width="60%" valign="middle" style="width: 60%;">
                                                    <h1 class="banner-title" style="margin: 0; color: #FFFFFF; font-size: 42px; font-weight: 700; line-height: 1.2; letter-spacing: -1px;">{{ $bannerTitle ?? $subject ?? 'SimPlug' }}</h1>
                                                    @if(isset($bannerSubtitle))
                                                    <p class="banner-subtitle" style="margin: 8px 0 0 0; color: #FFFFFF; font-size: 16px; opacity: 0.95; font-weight: 400;">{{ $bannerSubtitle }}</p>
                                                    @endif
                                                </td>
                                                <td width="40%" align="right" valign="middle" style="width: 40%;">
                                                    <div class="banner-icon" style="width: 90px; height: 90px; background-color: rgba(255, 255, 255, 0.15); border-radius: 50%; display: inline-block; position: relative;">
                                                        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #FFFFFF; font-size: 40px;">{{ $bannerIcon ?? '📧' }}</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    @endif
                    
                    <!-- Main Content Section -->
                    <tr>
                        <td class="main-padding" style="padding: 40px 30px;">
                            @if(isset($heading))
                            <h2 class="content-heading" style="margin: 0 0 12px 0; color: #2C2C2C; font-size: 28px; font-weight: 700; line-height: 1.3;">{{ $heading }}</h2>
                            @endif
                            
                            @if(isset($name) && is_string($name) && !empty($name))
                            <p class="content-text" style="margin: 0 0 24px 0; color: #4A4A4A; font-size: 16px; line-height: 1.6;">Hello, <strong style="color: #1812AE;">{{ $name }}</strong>,</p>
                            @endif
                            
                            <div class="content-text" style="margin: 0 0 20px 0; color: #4A4A4A; font-size: 16px; line-height: 1.6;">
                                {!! nl2br(e($messageBody)) !!}
                            </div>
                            
                            @if(isset($buttonText) && isset($buttonUrl))
                            <!-- Button -->
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" class="button-wrapper" style="margin: 0 auto;">
                                            <tr>
                                                <td class="button-cell" align="center" style="padding: 0;">
                                                    <a href="{{ $buttonUrl }}" class="button-link" style="display: inline-block; padding: 16px 32px; background-color: #1812AE; color: #FFFFFF; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px; min-width: 200px; text-align: center;">{{ $buttonText }}</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            @endif
                            
                            @if(isset($notice))
                            <!-- Notice Box -->
                            <div style="background-color: #d9d9f3d1; border-left: 4px solid #1812AE; padding: 16px; border-radius: 4px; margin: 24px 0;">
                                <p style="margin: 0; color: #4A4A4A; font-size: 14px; line-height: 1.5;">
                                    {!! $notice !!}
                                </p>
                            </div>
                            @endif
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
                                            <a href="mailto:{{ 'info@SimPlug.com.ng' }}" style="color: #1812AE; text-decoration: none; font-weight: 500;">{{ 'info@SimPlug.com.ng' }}</a>
                                            @if(isset($supportPhone))
                                            or <a href="tel:{{ $supportPhone }}" style="color: #1812AE; text-decoration: none; font-weight: 500;">{{ $supportPhone }}</a>
                                            @endif
                                        </p>
                                    </td>
                                </tr>
                                
                                <!-- Social Media Section -->
                                @if(isset($showSocialMedia) && $showSocialMedia)
                                <tr>
                                    <td align="center" style="padding-bottom: 24px;">
                                        <p style="margin: 0 0 16px 0; color: #4A4A4A; font-size: 14px; line-height: 1.6;">
                                            Stay connected! Follow us on
                                        </p>
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: 0 auto;">
                                            <tr>
                                                @if(isset($facebookUrl))
                                                <td style="padding: 0 8px;">
                                                    <a href="{{ $facebookUrl }}" class="social-icon" style="display: inline-block; width: 40px; height: 40px; background-color: #1812AE; border-radius: 50%; text-align: center; line-height: 40px; text-decoration: none;">
                                                        <span style="color: #FFFFFF; font-size: 18px; font-weight: bold;">f</span>
                                                    </a>
                                                </td>
                                                @endif
                                                @if(isset($linkedinUrl))
                                                <td style="padding: 0 8px;">
                                                    <a href="{{ $linkedinUrl }}" class="social-icon" style="display: inline-block; width: 40px; height: 40px; background-color: #1812AE; border-radius: 50%; text-align: center; line-height: 40px; text-decoration: none;">
                                                        <span style="color: #FFFFFF; font-size: 14px; font-weight: bold;">in</span>
                                                    </a>
                                                </td>
                                                @endif
                                                @if(isset($twitterUrl))
                                                <td style="padding: 0 8px;">
                                                    <a href="{{ $twitterUrl }}" class="social-icon" style="display: inline-block; width: 40px; height: 40px; background-color: #1812AE; border-radius: 50%; text-align: center; line-height: 40px; text-decoration: none;">
                                                        <span style="color: #FFFFFF; font-size: 16px; font-weight: bold;">X</span>
                                                    </a>
                                                </td>
                                                @endif
                                                @if(isset($instagramUrl))
                                                <td style="padding: 0 8px;">
                                                    <a href="{{ $instagramUrl }}" class="social-icon" style="display: inline-block; width: 40px; height: 40px; background-color: #1812AE; border-radius: 50%; text-align: center; line-height: 40px; text-decoration: none;">
                                                        <span style="color: #FFFFFF; font-size: 18px;">📷</span>
                                                    </a>
                                                </td>
                                                @endif
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                @endif
                                
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
