<?php require_once ('../../../../../wp-config.php');
newsletter_daily_func();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html data-editor-version="2" class="sg-campaigns" xmlns="http://www.w3.org/1999/xhtml">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
      <!--[if !mso]><!-->
      <meta http-equiv="X-UA-Compatible" content="IE=Edge">
      <!--<![endif]-->
      <!--[if (gte mso 9)|(IE)]>
      <xml>
        <o:OfficeDocumentSettings>
          <o:AllowPNG/>
          <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
      </xml>
      <![endif]-->
      <!--[if (gte mso 9)|(IE)]>
  <style type="text/css">
    body {width: 600px;margin: 0 auto;}
    table {border-collapse: collapse;}
    table, td {mso-table-lspace: 0pt;mso-table-rspace: 0pt;}
    img {-ms-interpolation-mode: bicubic;}
  </style>
<![endif]-->
      <style type="text/css">
      body,table,td,a{-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%; max-width:720px;}
            table, td{mso-table-lspace:0;mso-table-rspace:0}
            img{-ms-interpolation-mode:bicubic}
            img{border:0;height:auto;line-height:100%;outline:0;text-decoration:none}
            table{border-collapse:collapse!important}
            body{height:100%!important;margin:0!important;padding:0!important;width:100%!important}
            a[x-apple-data-detectors]{color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}
            u+#body a{color:inherit;text-decoration:none;font-size:inherit;font-family:inherit;font-weight:inherit;line-height:inherit}
            #MessageViewBody a{color:inherit;text-decoration:none;font-size:inherit;font-family:inherit;font-weight:inherit;line-height:inherit}a{color:#4C4084;font-weight:600;text-decoration:underline}
            a:hover{color:#000000;text-decoration:none!important}
            @media screen and (min-width:600px){
                h1{font-size:48px!important;line-height:48px!important}
                .intro{font-size:24px!important;line-height:36px!important}
            }
            .h-resize20px {height:20px !important; }
            .lh40 {line-height:40px !important}
            .text32 {font-size:32px !important}
            .w-resize85 {width:85% !important; }
            .main-div {
                color:#2b2b2b;
                font-family:Source Sans Pro,Roboto,Helvetica,Arial,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol;
                font-size:18px;
                font-weight:400;
                line-height:28px;
                margin:0 auto;
                padding:40px 20px 40px 20px;
            }

            .main-div, table {                
                max-width:720px;
            }

            .brand-logo {

                text-align:center;
            }
            .main-div .email-title{
                text-align:center;
                color:#2b2b2b;font-family: serif;
            }
            img {
                max-width: 100%;
                max-height: 100%;
                display: block;
            }
            .link-btn {
                background-color: #4c4084;
                color: #FFF;
                /*font-family: Source Sans Pro !important;*/
                font-size: 11px !important;
                line-height: 35px !important;
                letter-spacing: 1px !important;
                height: auto;
                border-radius: 1px;
                padding: 0 16px;
                box-sizing: border-box;
                text-decoration: none;
                display: inline-block;
            }
            .link-btn:hover {
                color: #FFF;
            }
            
            a.text-para {
                color: inherit;
                text-decoration: none;
                font-weight: inherit;
                font-size: inherit;
            }
            </style>
             <!--user entered Head Start-->

     <!--End Head user entered-->
    </head>
    <body>
    
<div lang="en" style="background-color: white; color: #2b2b2b; font-family: 'Source Sans Pro',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'; font-size: 18px; font-weight: 400; line-height: 28px; margin: 0 auto; max-width: 720px; padding: 40px 20px 40px 20px;text-align: center;" role="article" aria-label="An email from Your Brand Name">

        <!--[if (gte mso 9)|(IE)]>
        <table cellspacing=0 cellpadding=0 border=0 width=720 align=center role=presentation><tr><td>
        <![endif]-->
        <div role=article aria-label="An email from Your Brand Name" lang=en class="main-div">

            <table width=100% border=0>
                <tbody>
                    <tr>
                        <td height=30 class="brand-logo" style="width:100%;text-align:center"><img src="https://staging.thehrempire.com/wp-content/uploads/2020/08/TheHREmpire-purpleblack-logo-2.png" alt="The HR Empire" style="text-align:center;"/></td>
                    </tr>
                    <tr>
                        <td height=15><h2 class="email-title" style="margin-bottom: 5px;">The HR Daily</h2></td>
                    </tr>
                    <tr>
                        <td><h3 class="email-title" style="margin-top: 0">{{{current_date}}}</h3></td>
                    </tr>
                    <tr>
                        <td height=0></td>
                    </tr>
                </tbody>
            </table>
            {{{email_content}}}
            <!-- Read more stories on thehrempire.com -->
            <table border="0" cellspacing="0" cellpadding="10" style="background-color:#fff;width: 100%">
                <tr>
                    <td style="text-align: center;"><a href="{{{home_url}}}">Read More on thehrempire.com</a></td>
                </tr>
            </table>
            <table border="0" cellspacing="0" cellpadding="10" style="background-color:#fff;">
                <tr>
                    <td>&nbsp;
                    </td>
                </tr>
            </table>
            <table border="0" width="100%" bgcolor="#EBEEEF">
                <tbody>
                    <tr>
                        <td>
                            <table border="0" width="96%" align="center">
                                <tbody>
                                    <tr>
                                        <td><footer style="color: #373939;margin-top: 20px;text-align:left;"><!-- This link uses descriptive text to inform the user what will happen with the link is tapped. -->
                                                <!-- It also uses inline styles since some email clients won't render embedded styles from the head. -->
                                                <p style="font-size: 14px; font-weight: 400; line-height: 24px; margin-top: 0px; font-family: 'Source Sans Pro'; text-align: left;"><a style="color: #373939; text-decoration: underline;" href="{{{privacy_policy_url}}}">Privacy Policy</a> | <a style="color: #373939; text-decoration: underline;" href="{{{terms_of_service_url}}}">Terms of service</a> | <a style="color: #373939; text-decoration: underline;" href="{{{contact_us_url}}}">Contact Us</a></p>
                                                <!-- The address element does exactly what it says. By default, it is block-level and italicizes text. You can override this behavior inline. -->

                                                <address style="font-size: 14px; font-style: normal; font-weight: 400; line-height: 24px; font-family: Source Sans Pro;">Copyright &copy; 2020 The HR Empire. All rights reserved.</address><address style="font-size: 14px; font-style: normal; font-weight: 400; line-height: 24px; font-family: 'Source Sans Pro';">Our address is 8000 Towers Crescent Drive, 13th Floor, Vienna,VA 22182, USA</address><address style="font-size: 14px; font-style: normal; font-weight: 400; line-height: 24px; padding-top: 10px; font-family: 'Source Sans Pro';">This cannot be copied, distributed, or displayed without prior written permission from The HR Empire</address></footer></td>
                                    </tr>
                                    <tr>
                                        <td height="20"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!--[if (gte mso 9)|(IE)]>
        </td></tr></table>
        <![endif]-->
</div>
    </body>
  </html>
<!--
<div lang="en" style="background-color: white; color: #2b2b2b; font-family: 'Source Sans Pro',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'; font-size: 18px; font-weight: 400; line-height: 28px; margin: 0 auto; max-width: 720px; padding: 40px 20px 40px 20px;text-align: center" role="article" aria-label="An email from Your Brand Name">
       

        [if (gte mso 9)|(IE)]>
        <table cellspacing=0 cellpadding=0 border=0 width=720 align=center role=presentation><tr><td>
        <![endif]
        <div role=article aria-label="An email from Your Brand Name" lang=en class="main-div">

            <table width=100% border=0>
                <tbody>
                    <tr>
                        <td height=30 class="brand-logo"><img src="https://staging.thehrempire.com/wp-content/uploads/2020/08/TheHREmpire-purpleblack-logo-2.png" width="278" height="56" alt="The HR Empire"/></td>
                    </tr>
                    <tr>
                        <td height=15><h2 class="email-title" style="margin-bottom: 5px;">The HR Daily</h2></td>
                    </tr>
                    <tr>
                        <td><h3 class="email-title" style="margin-top: 0">{{{current_date}}}</h3></td>
                    </tr>
                    <tr>
                        <td height=0></td>
                    </tr>
                </tbody>
            </table>
            {{{email_content}}}
             Read more stories on thehrempire.com 
            <table border="0" cellspacing="0" cellpadding="10" style="background-color:#fff;width: 100%">
                <tr>
                    <td style="text-align: center;"><a href="{{{home_url}}}">Read More on thehrempire.com</a></td>
                </tr>
            </table>
            <table border="0" cellspacing="0" cellpadding="10" style="background-color:#fff;">
                <tr>
                    <td>&nbsp;
                    </td>
                </tr>
            </table>
            <table border="0" width="100%" bgcolor="#EBEEEF">
                <tbody>
                    <tr>
                        <td>
                            <table border="0" width="96%" align="center">
                                <tbody>
                                    <tr>
                                        <td><footer style="color: #373939;margin-top: 20px"> This link uses descriptive text to inform the user what will happen with the link is tapped. 
                                                 It also uses inline styles since some email clients won't render embedded styles from the head. 
                                                <p style="font-size: 14px; font-weight: 400; line-height: 24px; margin-top: 0px; font-family: 'Source Sans Pro'; text-align: left;"><a style="color: #373939; text-decoration: underline;" href="{{{privacy_policy_url}}}">Privacy Policy</a> | <a style="color: #373939; text-decoration: underline;" href="{{{terms_of_service_url}}}">Terms of service</a> | <a style="color: #373939; text-decoration: underline;" href="{{{contact_us_url}}}">Contact Us</a></p>
                                                 The address element does exactly what it says. By default, it is block-level and italicizes text. You can override this behavior inline. 

                                                <address style="font-size: 14px; font-style: normal; font-weight: 400; line-height: 24px; font-family: Source Sans Pro;">Copyright &copy; 2020 The HR Empire. All rights reserved.</address><address style="font-size: 14px; font-style: normal; font-weight: 400; line-height: 24px; font-family: 'Source Sans Pro';">Our address is 8000 Towers Crescent Drive, 13th Floor, Vienna,VA 22182, USA</address><address style="font-size: 14px; font-style: normal; font-weight: 400; line-height: 24px; padding-top: 10px; font-family: 'Source Sans Pro';">This cannot be copied, distributed, or displayed without prior written permission from The HR Empire</address></footer></td>
                                    </tr>
                                    <tr>
                                        <td height="20"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        [if (gte mso 9)|(IE)]>
        </td></tr></table>
        <![endif]
</div>-->