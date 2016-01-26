<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEWS</title>
    <style type="text/css">
        #outlook a {padding:0;}
        body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
        .ExternalClass {width:100%;}
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing.  More on that: http://www.emailonacid.com/forum/viewthread/43/ */
        #backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
        img {outline:none; text-decoration:none;border:none; -ms-interpolation-mode: bicubic;}
        a img {border:none;}
        .image_fix {display:block;}
        p {margin: 0px 0px !important;}
        table td {border-collapse: collapse;}
        table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
        table[class=full] { width: 100%; clear: both; }
        @media only screen and (max-width: 640px) {
            a[href^="tel"], a[href^="sms"] {
                text-decoration: none;
                color: #ffffff; /* or whatever your want */
                pointer-events: none;
                cursor: default;
            }
            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                text-decoration: default;
                color: #ffffff !important;
                pointer-events: auto;
                cursor: default;
            }
            table[class=devicewidth] {width: 440px!important;text-align:center!important;}
            table[class=devicewidthinner] {width: 420px!important;text-align:center!important;}
            table[class="sthide"]{display: none!important;}
            img[class="bigimage"]{width: 420px!important;height:219px!important;}
            img[class="col2img"]{width: 420px!important;height:258px!important;}
            img[class="image-banner"]{width: 440px!important;height:106px!important;}
            td[class="menu"]{text-align:center !important; padding: 0 0 10px 0 !important;}
            td[class="logo"]{padding:10px 0 5px 0!important;margin: 0 auto !important;}
            img[class="logo"]{padding:0!important;margin: 0 auto !important;}

        }

        @media only screen and (max-width: 480px) {
            a[href^="tel"], a[href^="sms"] {
                text-decoration: none;
                color: #ffffff;
                pointer-events: none;
                cursor: default;
            }
            .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
                text-decoration: default;
                color: #ffffff !important;
                pointer-events: auto;
                cursor: default;
            }
            table[class=devicewidth] {width: 280px!important;text-align:center!important;}
            table[class=devicewidthinner] {width: 260px!important;text-align:center!important;}
            table[class="sthide"]{display: none!important;}
            img[class="bigimage"]{width: 260px!important;height:136px!important;}
            img[class="col2img"]{width: 260px!important;height:160px!important;}
            img[class="image-banner"]{width: 280px!important;height:68px!important;}

        }
    </style>
</head>
<body>
{{-- @include('emails.partials._preheader') --}}
@include('emails.partials._header')
@yield('content')
{{-- @include('emails.partials._footer')--}}
</body>
</html>