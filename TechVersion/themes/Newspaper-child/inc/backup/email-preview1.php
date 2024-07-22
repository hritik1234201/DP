<?php

if( isset($_GET['preview']) && $_GET['preview'] == 'yes' ){
	add_action( 'wp_loaded','preview_email_template' );
	
	add_filter( 'wp_mail_content_type', 'set_content_type' );
 
	function set_content_type( $content_type ) {
		return 'text/html';
	}
}

function preview_email_template(){
	
	/*Change this variables accordingly : comments*/
	$tester_email = 'ramkira@anteriad.com';
	$daily_subject = 'Daily Shots';
	$weekly_subject = 'Weekly Bytes';
	$monthly_subject = 'Monthly Brief';
	
    /*Starts newsletter_daily_func : comments*/
	if(isset($_GET['newsletter']) && $_GET['newsletter'] == 'daily'){
		
        global $wpdb;
        $top_news = '';
        $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_date < '" . date('Y-m-d') . "' AND post_type IN ('posts') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 0, 1";
        $result = $wpdb->get_row($query, OBJECT);

        if(!empty($result)){
            
            if ($top_news === '') {
                $top_news = $result->post_title;
            }
            $email_content .= '<table border="0" cellspacing="0" cellpadding="0" style="width: 100%">
                                                <tr>
                                                    <td>
                                                    <h3 style="margin: 0 0 5px 0;font-size: 20px;">Today\'s highlights</h3>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
                                                    </td>
                                                </tr>';

            $email_content .= '<tr>
                                <td style="padding: 10px 0">
                                    <p><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>
                                    <p>';

            if (!empty($result->post_excerpt)) {
                $paragraph = $result->post_excerpt;
            } else {
                $paragraph = '';
                $str = $result->post_content;
                $str = strip_tags($str);
                $paragraph = substr($str, 0, 300);
                $paragraph = rtrim($paragraph, '.') . '...';
            }
            $para = $paragraph;
            $email_content .= $para . '</p>
                                                    <p><a class="link-btn" style="background-color: #04a353;color: #FFF;font-size: 11px !important;line-height: 35px !important;letter-spacing: 1px !important;height: auto;border-radius: 1px;padding: 0 16px;box-sizing: border-box;text-decoration: none;display: inline-block;" href="' . get_the_permalink($result->ID) . '"> Read More </a></p>
                                                </td>
                                            </tr>
                                        </table>';

        }
	
        //Second Row
        $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_date >= '" . date('Y-m-d 11:00', strtotime('-1 day')) . "' AND post_date < '" . date('Y-m-d 10:59') . "' AND post_type IN ('tech_news') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 1, 4";
        $results = $wpdb->get_results($query, OBJECT);

        if(!empty($results)){
            foreach ($results as $result) {
    
                $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom: 20px;">
                                    <tr style="height: 140px; vertical-align: top;">
                                        <td style="width: 25%;padding: 0 20px 0 0;vertical-align: top;">
                                            <a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;border-radius: 5px;" /></a>
                                        </td>
                                        <td style="padding: 0 0 10px 10px; width:75%">
                                            <p style="margin: 0 0 5px 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>
                                            <p style="margin-top: 0">';
                if (!empty($result->post_excerpt)) {
                    $paragraph = $result->post_excerpt;
                } else {
                    $paragraph = '';
                    $str = $result->post_content;
                    $str = strip_tags($str);
                    $paragraph = substr($str, 0, 100);
                    $paragraph = rtrim($paragraph, '.') . '...';
                }
                $para = $paragraph;
                $email_content .=  ' <a  style="color:#0D0128;text-decoration:none;font-size:15px;font-weight:400;"  href="' . get_the_permalink($result->ID) . '">Read More</a>';
                $email_content .= '</p>
                                        </td>
                                    </tr>
                                </table>';
            }
        }

        $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('tech_news') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 5, 3";
        $results = $wpdb->get_results($query, OBJECT);
        
        if(!empty($results)){
		    $email_content .= '<table width=100% border=0 style="margin: 30px 0;margin-bottom: 20px;">
								<tbody>
									<tr>
										<td style="width:100%;border-bottom: 1px solid #ddd;padding: 0 0 10px 0;font-weight: bold;font-size: 20px">In case you missed it</td>
									</tr>
								</tbody>
							</table>';
	    
        
            foreach ($results as $result) {
                $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%">
                                        <tr style="height: 140px; vertical-align: top;">
                                            <td style="width: 25%;padding: 0 20px 0 0;vertical-align: top;">
                                                <a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
                                            </td>
                                            <td style="padding: 0 0 10px 10px; width:75%">
                                                <p style="margin: 0 0 5px 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>
                                                <p style="margin-top: 0">';
                if (!empty($result->post_excerpt)) {
                    $paragraph = $result->post_excerpt;
                } else {
                    $paragraph = '';
                    $str = $result->post_content;
                    $str = strip_tags($str);
                    $paragraph = substr($str, 0, 100);
                    $paragraph = rtrim($paragraph, '.') . '...';
                    ;
                }
                $para = $paragraph;
                $email_content .=  ' <a style="color:#0D0128;text-decoration:none;font-size:15px;font-weight:400;" href="' . get_the_permalink($result->ID) . '">Read More</a>';
                $email_content .= '</p>
                                                    </td>
                                                </tr>
                                            </table>';
            }
        }
	    /*Ends newsletter_daily_func : comments*/
	
        /*Starts daily newsletter above content HTML : comments*/
        $above_content = '
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
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
                        * {
                            font-family : Helvetica, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol;
                            color : #333333;
                        }
                        h3 {
                            font-family : Helvetica, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol;
                        }
                        body {
                            max-width : 720px;
                            margin : 0 auto;
                        }
                        body, table, td, a {
                            font-size : 15px;
                            line-height : 28px;
                        }
                        img {
                            border : 0;
                            height : auto;
                            line-height : 100%;
                            outline : 0;
                            text-decoration : none;
                        }
                        table {
                            border-collapse : collapse !important ;
                        }
                        a[x-apple-data-detectors] {
                            color : inherit !important ;
                            text-decoration : none !important ;
                            font-size : inherit !important ;
                            font-family : inherit !important ;
                            font-weight : inherit !important ;
                            line-height : inherit !important ;
                        }
                        a {
                            color : #04a353;
                            font-weight : 600;
                            text-decoration : none;
                        }
                        a:hover {
                            color : #000000;
                            text-decoration : underline !important ;
                        }
                        .main-div {
                            color : #2b2b2b;
                            font-family : Helvetica, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol;
                            font-size : 18px;
                            font-weight : 400;
                            line-height : 28px;
                            margin : 0 auto;
                            padding : 0 20px 40px 20px;
                        }
                        .main-div, table {
                            max-width : 720px;
                        }
                        .main-div .email-title {
                            text-align : center;
                            color : #2b2b2b;
                            font-family : serif;
                        }
                        img {
                            max-width : 100%;
                            max-height : 100%;
                            display : block;
                        }
                        .link-btn {
                            background-color : #04a353;
                            color : #FFF;
                            font-size : 11px !important ;
                            line-height : 35px !important ;
                            letter-spacing : 1px !important ;
                            height : auto;
                            border-radius : 1px;
                            padding : 0 16px;
                            box-sizing : border-box;
                            text-decoration : none;
                            display : inline-block;
                        }
                        .link-btn:hover {
                            color : #FFF;
                        }
                        a.text-para {
                            color : inherit;
                            text-decoration : none;
                            font-weight : inherit;
                            font-size : inherit;
                        }
                        @media screen and (min-width: 600px) {
                            h1 {
                                font-size : 48px !important ;
                                line-height : 48px !important ;
                            }
                            .intro {
                                font-size : 24px !important ;
                                line-height : 36px !important ;
                            }
                        }
                        @media screen and (max-width: 600px) {
                            .single-row-news td {
                                width : 100% !important ;
                                display : block;
                                padding : 0 !important ;
                            }
                            .single-row-news {
                                margin-bottom : 20px;
                            }
                        }
                    </style>
                    <!--user entered Head Start-->

                    <!--End Head user entered-->
                    </head>
                    <body style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;max-width:720px;margin: 0 auto;font-size: 15px;line-height: 28px;color: #333333;">

                        <div lang="en" style="" role="article" aria-label="An email from "'.get_bloginfo('name').'">

                            <!--[if (gte mso 9)|(IE)]>
                            <table cellspacing=0 cellpadding=0 border=0 width=720 align=center role=presentation><tr><td>
                            <![endif]-->
                            <div role=article aria-label="An email from '.get_bloginfo('name').'" lang=en class="main-div" style="font-weight:400;margin:0 auto;padding:0 20px 40px 20px;color: #333333;">

                                <table width=100% border=0 style="margin-bottom: 30px;border-bottom: 1px solid #ddd">
                                    <tbody>
                                        <tr>
                                            <td height=50 style="width:100%;padding: 0 0 0px 0;width:60%"><img src="https://techversions.com/wp-content/uploads/2021/01/TV-Logo-243-x-22.png" alt="'.get_bloginfo('name').'" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" />
                                            </td>
                                            <td height=50 style="width:100%;padding: 0 0 0px 0;width:40%;text-align:right;"><h2 style="color:#7F8182;font-size:25px;font-family:Gelasio">'.$daily_subject.'</h2>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>';
				/*Ends daily newsletter above content HTML : comments*/
								
				/*Starts daily newsletter below content HTML : comments*/
				$below_content ='<table border="0" width="100%" style="width:100%; text-align: center;border-top:1px solid #ddd">
                                    <tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 13px !important;color:#FFF;margin-top:20px;padding:5px 40px;background-color : #04a353;line-height : 35px !important ;letter-spacing : 0.5px !important ;height : auto;border-radius : 3px;box-sizing : border-box;text-decoration : none;display : inline-block;font-weight:600" href="{{{news_url}}}">  Read More News   </a></p></td></tr>
                                </table>
                                <!--START - FOOTER-->
                                <table class="module" role="module" data-type="social" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;background-color: #ebeeef;margin-top:20px " data-muid="74ca2758-9d56-4d9f-971a-e02b9cc8d326">
                                    <tbody>
                                    
                                        <tr>
                                        <td><h3 style="text-align:center;color:#04a353;margin:10px 0 20px 0;padding:20px 0px 0px 0px;">Follow us on</h3></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" style="" align="center">
                                                <table align="center" style="-webkit-margin-start:auto;-webkit-margin-end:auto;">
                                                    <tbody><tr align="center"><td style="padding: 0px 5px;" class="social-icon-column">
                                                                <a role="social-icon-link" href="https://www.facebook.com/techversions/" target="_blank" alt="Facebook" title="Facebook" style="">
                                                                    <img role="social-icon" alt="Facebook" title="Facebook" src="https://techversions.com/assets/facebook.png" />
                                                                </a>
                                                            </td><td style="padding: 0px 5px;" class="social-icon-column">
                                                                <a role="social-icon-link" href="https://twitter.com/tech_versions" target="_blank" alt="Twitter" title="Twitter">
                                                                    <img role="social-icon" alt="Twitter" title="Twitter" src="https://techversions.com/assets/twitter.png" />
                                                                </a>
                                                            </td><td style="padding: 0px 5px;" class="social-icon-column">
                                                                <a role="social-icon-link" href="https://www.linkedin.com/company/tech-versions/" target="_blank" alt="LinkedIn" title="LinkedIn">
                                                                    <img role="social-icon" alt="LinkedIn" title="LinkedIn" src="https://techversions.com/assets/linkedin.png" />
                                                                </a>
                                                            </td></tr></tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table border="0" cellspacing="0" cellpadding="10" style="background-color:#ebeeef;width: 100%">
                                    <tr>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;color:#04a353">

                                            <p>
                                                <a style="font-size: 13px;color:#04a353;font-weight : 600;text-decoration : none;" href="/contact-us/">Contact Us</a>
                                                <br />
                                                <a style="font-size: 13px;color:#04a353;font-weight : 600;text-decoration : none;" href="/terms-of-service/">Terms of service</a>
                                                <br/>
                                                <a style="font-size: 13px;color:#04a353;font-weight : 600;text-decoration : none;" href="/privacy-policy/">Privacy Policy</a>
                                                <br/>
                                                <a href="'.site_url('my-account/email-preferences').'" style="font-size: 13px;color:#04a353;font-weight : 600;text-decoration : none;">Manage Your Preferences</a>
                                                <br/>
                                                <a href="<%asm_group_unsubscribe_raw_url%>" style="font-size: 13px;color : #04a353;font-weight : 600;text-decoration : none;">Unsubscribe</a>
                                            </p>
                                            <address style="font-size: 13px; font-style: normal; font-weight: 400; line-height: 24px; color:#7F8182;width: 70%;margin: 30px auto 20px auto;">&copy; '.date('Y').' '.get_bloginfo('name').'. All rights reserved.<br/> 8000 Towers Crescent Drive, 13th Floor, Vienna,VA 22182, USA</address>
                                            <address style="font-size: 12px; font-style: normal; font-weight: 400; line-height: 24px; color:#7F8182">This newsletter cannot be copied, distributed, or displayed without prior written permission from '.get_bloginfo('name').'.</address>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <!--[if (gte mso 9)|(IE)]>
                            </td></tr></table>
                            <![endif]-->
                        </div>
                    </body>
				</html>';
				/*Ends daily newsletter below content HTML : comments*/
				
			$body = $above_content.$email_content.$below_content;
			
			echo $body;
	
			if(isset($_GET['sendgrid']) && $_GET['sendgrid'] == 'send'){
				
				$dynamic_template_id = sendgridController::SG_DYNAMIC_EMAIL_TEMPLATES['newsletter_daily'];
				
				if (!empty($top_news)) {
					
					$response = sendgridController::send_newsletter_test($dynamic_template_id, sendgridController::SG_UNSUBSCRIBE_GROUPS['daily'], array(
								'email_content' => $email_content,
								'current_date' => date('l, F j, Y'),
								'curr_year' => date('Y'),
								'brand_name' => get_bloginfo('name'),
								'newsletter_title' => $daily_subject,
								'home_url' => home_url(),
								'top_news' => $top_news,
								'privacy_policy_url' => site_url('privacy-policy'),
								'terms_of_service_url' => site_url('terms-of-service'),
								'contact_us_url' => site_url('contact-us'),
								'news_url' => site_url('news'),
								'facebook_link' => esc_attr(get_option('facebook_link')),
								'twitter_link' => esc_attr(get_option('twitter_link')),
								'linkedin_link' =>  esc_attr(get_option('linkedin_link')),
								'instagram_link' =>  esc_attr(get_option('instagram_link')),
								'manage_your_preferences_link' => site_url('my-account/email-preferences'),
									), 'daily');
				}

				exit();
			}else{	
				// wp_mail( $tester_email, get_bloginfo('name').' | '.$daily_subject, $body);
            }
		
	}else if(isset($_GET['newsletter']) && $_GET['newsletter'] == 'weekly'){
		
		/*Starts newsletter_weekly_func*/
		
		global $wpdb;
        $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_type IN ('tech_news') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` ASC LIMIT 0, 1";
        $result = $wpdb->get_row($query, OBJECT);
        $todays_post = $result;
	
	    if(!empty($result)){
		
		    $email_content .= '<table border="0" cellspacing="0" cellpadding="0" style="width: 100%">
								<tr>
									<td>
									   <h3 style="margin: 0 0 5px 0;font-size: 20px;">Top News</h3>
									</td>
								</tr>
								<tr>
									<td>
										<a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
									</td>
								</tr>';
			$email_content .= '<tr>
									<td style="padding: 10px 0">
										<p><strong><a class="text-para" href="' . get_the_permalink($result->ID) . '" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;">' . $result->post_title . '</a></strong></p>';

            if (!empty($result->post_excerpt)) {
                $paragraph = $result->post_excerpt;
            } else {
                $paragraph = '';
                $str = $result->post_content;
                $str = strip_tags($str);
                $paragraph = substr($str, 0, 300);
                $paragraph = rtrim($paragraph, '.') . '...';
		    }
            $para = $paragraph;
            $email_content .= '<p>' . $para . '</p>
                                                <p><a class="link-btn" style="background-color: #04a353;color: #FFF;font-size: 11px !important;line-height: 35px !important;letter-spacing: 1px !important;height: auto;border-radius: 20px;padding: 0 16px;box-sizing: border-box;text-decoration: none;display: inline-block;" href="' . get_the_permalink($result->ID) . '"> Read More </a></p>
                                            </td>
                                        </tr>
                                    </table>';
	}

    //Second Row
    $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_type IN ('tech_news') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` ASC LIMIT 1, 4";
    $results = $wpdb->get_results($query, OBJECT);

    if(!empty($results)){
        
        foreach ($results as $result) {
            $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom: 20px;">
                                            <tr style="height: 140px; vertical-align: top;">
                                                <td style="width: 25%;padding: 0 20px 0 0;vertical-align: top;">
                                                    <a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
                                                </td>
                                                <td style="padding: 0 0 10px 10px; width:75%">
                                                    <p style="margin: 0 0 5px 0"><strong><a class="text-para" href="' . get_the_permalink($result->ID) . '" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;">' . $result->post_title . '</a></strong></p>
                                                    <p style="margin-top: 0">';
            if (!empty($result->post_excerpt)) {
                $paragraph = $result->post_excerpt;
            } else {
                $paragraph = '';
                $str = $result->post_content;
                $str = strip_tags($str);
                $paragraph = substr($str, 0, 100);
                $paragraph = rtrim($paragraph, '.') . '...';
            }
            $para = $paragraph;
            $email_content .= $para . ' <a style="color:#04a353;font-weight:600;text-decoration:none;font-size:15px;font-weight:400;" href="' . get_the_permalink($result->ID) . '">Read More</a>';
            $email_content .= '</p>
                                                </td>
                                            </tr>
                                        </table>';
        }
    
        $email_content .= '<table border="0" width="100%" style="width:100%; text-align: center">
                                        <tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;margin-top:20px;padding:5px 30px;background-color : #04a353;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;" href="' . site_url('news') . '">  Click here for more news  </a></p></td></tr>
                                    </table>';
    }


    //START -- Resource ROw
    $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_type IN ('e_books','infographics','white_papers') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` ASC LIMIT 1, 3";
    $results = $wpdb->get_results($query, OBJECT);
	
    if(count($results) < 3){
        $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('e_books','infographics','white_papers') AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` DESC LIMIT 1, 3";
        $results = $wpdb->get_results($query, OBJECT);
    }

    if(!empty($results)){
		
		$email_content .= '<table width = 100% border = 0 style = "margin: 30px 0;margin-bottom: 20px;">
						<tbody>
						<tr>
						<td style = "width:100%;border-bottom: 1px solid #ddd;padding: 0 0 10px 0;font-weight: bold;font-size: 20px">Top Resources</td>
						</tr>
						</tbody>
					</table>';
	
		$email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom: 20px;">
											<tr style="height: 140px; vertical-align: top;">';
		$i = 0;
		foreach ($results as $result) {
           $email_content .= '<td style="width: 33%;margin-right:10px;padding: 0 10px">'
					. '<p><a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a></p>'
					. '<p style="margin: 0 0 5px 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>'
					. '<p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;margin-top:20px;padding:5px 30px;background-color : #04a353;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;" href="' . get_the_permalink($result->ID) . '">Download for free</a></p>'
					. '</td>';
			$i++;
		}
		$email_content .= ' </tr>
						</table>';
										
	}

    // Must Read Blogs
    $query = "SELECT * FROM `{$wpdb->prefix}posts` WHERE post_type IN ('post') AND post_date >= '" . date('Y-m-d', strtotime('-1 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "'  AND post_status = 'publish' ORDER BY `{$wpdb->prefix}posts`.`post_date` ASC LIMIT 0, 3";
    $results = $wpdb->get_results($query, OBJECT);
	
	if(!empty($results)){
		
		$email_content .= '<table width = 100% border = 0 style = "margin: 30px 0;margin-bottom: 20px;">
					<tbody>
					<tr>
					<td style = "width:100%;border-bottom: 1px solid #ddd;padding: 0 0 10px 0;font-weight: bold;font-size: 20px">Must read Blogs</td>
					</tr>
					</tbody>
					</table>';
	
		foreach ($results as $result) {
			$email_content .= '<table class = "single-row-news" border = "0" cellspacing = "0" cellpadding = "0" style = "width: 100%">
										<tr style = "height: 140px; vertical-align: top;">
										<td style = "width: 25%;padding: 0 20px 0 0;vertical-align: top;">
										<a href = "' . get_the_permalink($result->ID) . '"><img src = "' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt = "' . $result->post_title . '" title = "' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" /></a>
										</td>
										<td style = "padding: 0 0 10px 10px; width:75%">
										<p style = "margin: 0 0 5px 0"><strong><a class = "text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href = "' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>
										<p style = "margin-top: 0">';
			if (!empty($result->post_excerpt)) {
				$paragraph = $result->post_excerpt;
			} else {
				$paragraph = '';
				$str = $result->post_content;
				$str = strip_tags($str);
				$paragraph = substr($str, 0, 100);
				$paragraph = rtrim($paragraph, '.') . '...';
			}
			$para = $paragraph;
			$email_content .= $para . ' <a style="color:#04a353;text-decoration:none;font-size:15px;font-weight:400;" href = "' . get_the_permalink($result->ID) . '">Read More</a>';
			$email_content .= '</p>
										</td>
										</tr>
										</table>';
		}
		
	}
	/*Ends newsletter_weekly_func*/
	
	/*Starts weekly newsletter above content HTML : comments*/
	$above_content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
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
                        * {
                            font-family : Helvetica, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol;
                            color : #333333;
                        }
                        h3 {
                            font-family : Helvetica, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol;
                        }
                        body {
                            max-width : 720px;
                            margin : 0 auto;
                        }
                        body, table, td, a {
                            font-size : 15px;
                            line-height : 28px;
                        }
                        img {
                            border : 0;
                            height : auto;
                            line-height : 100%;
                            outline : 0;
                            text-decoration : none;
                        }
                        table {
                            border-collapse : collapse !important ;
                        }
                        a[x-apple-data-detectors] {
                            color : inherit !important ;
                            text-decoration : none !important ;
                            font-size : inherit !important ;
                            font-family : inherit !important ;
                            font-weight : inherit !important ;
                            line-height : inherit !important ;
                        }
                        a {
                            color : #04a353;
                            font-weight : 600;
                            text-decoration : none;
                        }
                        a:hover {
                            color : #000000;
                            text-decoration : underline !important ;
                        }
                        .main-div {
                            color : #2b2b2b;
                            font-family : Helvetica, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol;
                            font-size : 18px;
                            font-weight : 400;
                            line-height : 28px;
                            margin : 0 auto;
                            padding : 0 20px 40px 20px;
                        }
                        .main-div, table {
                            max-width : 720px;
                        }
                        .main-div .email-title {
                            text-align : center;
                            color : #2b2b2b;
                            font-family : serif;
                        }
                        img {
                            max-width : 100%;
                            max-height : 100%;
                            display : block;
                        }
                        .link-btn {
                            background-color : #04a353;
                            color : #FFF;
                            font-size : 11px !important ;
                            line-height : 35px !important ;
                            letter-spacing : 1px !important ;
                            height : auto;
                            border-radius : 1px;
                            padding : 0 16px;
                            box-sizing : border-box;
                            text-decoration : none;
                            display : inline-block;
                        }
                        .link-btn:hover {
                            color : #FFF;
                        }
                        a.text-para {
                            color : inherit;
                            text-decoration : none;
                            font-weight : inherit;
                            font-size : inherit;
                        }
                        @media screen and (min-width: 600px) {
                            h1 {
                                font-size : 48px !important ;
                                line-height : 48px !important ;
                            }
                            .intro {
                                font-size : 24px !important ;
                                line-height : 36px !important ;
                            }
                        }
                        @media screen and (max-width: 600px) {
                            .single-row-news td {
                                width : 100% !important ;
                                display : block;
                                padding : 0 !important ;
                            }
                            .single-row-news {
                                margin-bottom : 20px;
                            }
                        }
                    </style>
                    <!--user entered Head Start-->

                    <!--End Head user entered-->
                    </head>
                    <body style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;max-width:720px;margin: 0 auto;font-size: 15px;line-height: 28px;color: #333333;">

                        <div lang="en" style="" role="article" aria-label="An email from '.get_bloginfo('name').'">

                            <!--[if (gte mso 9)|(IE)]>
                            <table cellspacing=0 cellpadding=0 border=0 width=720 align=center role=presentation><tr><td>
                            <![endif]-->
                            <div role=article aria-label="An email from Your '.get_bloginfo('name').'" lang=en class="main-div" style="font-weight:400;margin:0 auto;padding:0 20px 40px 20px;color: #333333;">

                                <table width=100% border=0 style="margin-bottom: 30px;border-bottom: 1px solid #ddd">
                                    <tbody>
                                        <tr>
                                            <td height=50 style="width:100%;padding: 0 0 0px 0;width:60%"><img src="https://techversions.com/wp-content/uploads/2020/02/Image20200212125837-1.png" alt="'.get_bloginfo('name').'" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" />
                                            </td>
                                            <td height=50 style="width:100%;padding: 0 0 0px 0;width:40%;text-align:right;"><h2 style="color:#7F8182;font-size:25px;font-family:Gelasio">'.$weekly_subject.'</h2>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>';
		/*Ends weekly newsletter above content HTML : comments*/
								
								
		/*Starts weekly newsletter below content HTML : comments*/
		$below_content = '<table border="0" width="100%" style="width:100%; text-align: center;border-top:1px solid #ddd">
                                    <tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 13px !important;color:#FFF;margin-top:20px;padding:5px 40px;background-color : #04a353;line-height : 35px !important ;letter-spacing : 0.5px !important ;height : auto;border-radius : 20px;box-sizing : border-box;text-decoration : none;display : inline-block;font-weight:600" href="{{{blogs_url}}}">  Check out more blogs </a></p></td></tr>
                                </table>
                                <!--START - FOOTER-->
                                <table class="module" role="module" data-type="social" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;background-color: #ebeeef;margin-top:20px " data-muid="74ca2758-9d56-4d9f-971a-e02b9cc8d326">
                                    <tbody>
                                    
                                        <tr>
                                        <td><h3 style="text-align:center;color:#04a353;margin:10px 0 20px 0;padding:20px 0px 0px 0px;">Follow us on</h3></td>
                                        </tr>
                                        <tr>
                                            <td valign="top" style="" align="center">
                                                <table align="center" style="-webkit-margin-start:auto;-webkit-margin-end:auto;">
                                                    <tbody><tr align="center"><td style="padding: 0px 5px;" class="social-icon-column">
                                                                <a role="social-icon-link" href="https://www.facebook.com/techversions/" target="_blank" alt="Facebook" title="Facebook" style="">
                                                                    <img role="social-icon" alt="Facebook" title="Facebook" src="https://techversions.com/assets/facebook.png" />
                                                                </a>
                                                            </td><td style="padding: 0px 5px;" class="social-icon-column">
                                                                <a role="social-icon-link" href="https://twitter.com/tech_versions" target="_blank" alt="Twitter" title="Twitter">
                                                                    <img role="social-icon" alt="Twitter" title="Twitter" src="https://techversions.com/assets/twitter.png" />
                                                                </a>
                                                            </td><td style="padding: 0px 5px;" class="social-icon-column">
                                                                <a role="social-icon-link" href="https://www.linkedin.com/company/tech-versions/" target="_blank" alt="LinkedIn" title="LinkedIn">
                                                                    <img role="social-icon" alt="LinkedIn" title="LinkedIn" src="https://techversions.com/assets/linkedin.png" />
                                                                </a>
                                                            </td></tr></tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table border="0" cellspacing="0" cellpadding="10" style="background-color:#ebeeef;width: 100%">
                                    <tr>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;color:#04a353">

                                            <p>
                                                <a style="font-size: 13px;color:#04a353;font-weight : 600;text-decoration : none;" href="/contact-us/">Contact Us</a>
                                                <br />
                                                <a style="font-size: 13px;color:#04a353;font-weight : 600;text-decoration : none;" href="/terms-of-service/">Terms of service</a>
                                                <br/>
                                                <a style="font-size: 13px;color:#04a353;font-weight : 600;text-decoration : none;" href="/privacy-policy/">Privacy Policy</a>
                                                <br/>
                                                <a href="'.site_url('my-account/email-preferences').'" style="font-size: 13px;color:#04a353;font-weight : 600;text-decoration : none;">Manage Your Preferences</a>
                                                <br/>
                                                <a href="<%asm_group_unsubscribe_raw_url%>" style="font-size: 13px;color : #04a353;font-weight : 600;text-decoration : none;">Unsubscribe</a>
                                            </p>
                                            <address style="font-size: 13px; font-style: normal; font-weight: 400; line-height: 24px; color:#7F8182;width: 70%;margin: 30px auto 20px auto;">&copy; {{curr_year}} '.get_bloginfo('name').'. All rights reserved.<br/> 8000 Towers Crescent Drive, 13th Floor, Vienna,VA 22182, USA</address>
                                            <address style="font-size: 12px; font-style: normal; font-weight: 400; line-height: 24px; color:#7F8182">This newsletter cannot be copied, distributed, or displayed without prior written permission from '.get_bloginfo('name').'.</address>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <!--[if (gte mso 9)|(IE)]>
                            </td></tr></table>
                            <![endif]-->
                        </div>
                    </body>
				</html>';
			/*Ends weekly newsletter below content HTML : comments*/
					
		$body = $above_content.$email_content.$below_content;
		
		echo $body;
		
		if(isset($_GET['sendgrid']) && $_GET['sendgrid'] == 'send'){
		
		$dynamic_template_id = sendgridController::SG_DYNAMIC_EMAIL_TEMPLATES['newsletter_weekly'];

		if (!empty($todays_post)) {
			$response = sendgridController::send_newsletter_test($dynamic_template_id, sendgridController::SG_UNSUBSCRIBE_GROUPS['weekly'], array(
						'email_content' => $email_content,
						'curr_year' => date('Y'),
						'brand_name' => get_bloginfo('name'),
						'newsletter_title' => $weekly_subject,
						'home_url' => home_url(),
						'top_news' => $top_news,
						'privacy_policy_url' => site_url('privacy-policy'),
						'terms_of_service_url' => site_url('terms-of-service'),
						'contact_us_url' => site_url('contact-us'),
						'blogs_url' => site_url('blog'),
						'facebook_link' => esc_attr(get_option('facebook_link')),
						'twitter_link' => esc_attr(get_option('twitter_link')),
						'linkedin_link' =>  esc_attr(get_option('linkedin_link')),
						'instagram_link' =>  esc_attr(get_option('instagram_link')),
						"manage_your_preferences_link" => site_url('my-account/email-preferences'),
							), 'weekly');
		}
		exit();
		
		}else{
		
			// wp_mail( $tester_email, get_bloginfo('name').' | '.$weekly_subject, $body);
		
		}
	
	}else if(isset($_GET['newsletter']) && $_GET['newsletter'] == 'monthly'){
		
		/*Starts newsletter_monthly_func : comments*/
	
	/*uncomment below 'if' statement when you are putting in functions.php file : comments*/
	/* if (date('Y-m-d') !== date('Y-m-t')) {
        exit(0);
    } */
    
	$start_date = date('Y-m-01');

    global $wpdb;

    //START -- Resources -- Row 1
    $query = "SELECT * FROM {$wpdb->prefix}posts as p LEFT JOIN {$wpdb->prefix}postmeta pm ON p.id = pm.post_id AND pm.meta_key LIKE 'post_views_count'  WHERE post_date >= '" . $start_date . "' AND post_date < '" . date('Y-m-t') . "' AND post_type IN ('e_books','infographics','white_papers') AND post_status = 'publish' GROUP BY WEEKOFYEAR(post_date) ORDER BY p.`post_date` ASC LIMIT 0, 4";
    $results = $wpdb->get_results($query, OBJECT);
	
	if(!empty($results)){
		
	    $email_content .= '<table width=100% border=0 style="margin: 0 0 20px 0;background-color:#ebeeef;border-top: 2px solid #04a353;">
							<tbody>
								<tr>
									<td style="width:100%;font-weight: bold;font-size: 25px;padding: 10px 15px;">Most Downloaded Resources</td>
								</tr>
							</tbody>
						</table>';

		$email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom: 20px;">
											';
		$i = 0;
		foreach ($results as $result) {
			if ($i == 0 || $i == 2) {
				$padding = 'padding: 0 15px 0 0';
				$email_content .= '<tr style="height: 140px; vertical-align: top;">';
			}
			if ($i == 1 || $i == 3) {
				$padding = 'padding: 0 0 0 15px';
			}

			$email_content .= '<td style="width: 50%;margin-right:15px;' . $padding . '">'
					. '<p><a href="' . get_the_permalink($result->ID) . '"><img src="' . esc_url(get_the_post_thumbnail_url($result->ID, 'one-large')) . '" alt="' . $result->post_title . '" title="' . $result->post_title . '" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;box-shadow: 1px 1px 6px 2px #eee;border:1px solid #eee;" /></a></p>'
					. '<p style="margin: 0 0 5px 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p>'
					. '<p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;margin-top:5px;padding:5px 30px;background-color : #04a353;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;border-radius:3px;" href="' . get_the_permalink($result->ID) . '">Download for free</a></p>'
					. '</td>';
			if ($i == 1 || $i == 3) {
				$email_content .= '</tr>';
			}
			$i++;
		}
		$email_content .= '</table>';
    //END -- Resource ROW -- Row 1
	
	}
	
    //START -- ROW 2 -- Blogs
    $query = "SELECT * FROM {$wpdb->prefix}posts p LEFT JOIN {$wpdb->prefix}postmeta pm ON p.id = pm.post_id AND pm.meta_key LIKE 'post_views_count'  WHERE post_date >= '" . $start_date . "' AND post_date < '" . date('Y-m-t') . "' AND post_type IN ('post') AND post_status = 'publish' ORDER BY pm.meta_value DESC LIMIT 0, 4";
    $result1 = $wpdb->get_results($query, OBJECT);

    $blogs_available = TRUE;
    if (!empty($result1)) {
        $email_content .= '<table width=100% border=0 style="margin: 0px 0 30px 0;background-color:#EBEEEF;border-top: 2px solid #04a353;">
                                    <tbody>
                                        <tr>
                                            <td style="width:100%;font-weight: bold;font-size: 25px;padding: 10px 15px;">Popular Blogs</td>
                                        </tr>
                                    </tbody>
                                </table>';
    } else {
        $blogs_available = FALSE;
    }

    if (!empty($result1)) {
        foreach ($result1 as $single_result) {
            $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom:10px;">
                                        <tr style="height: 140px; vertical-align: top;">
                                            <td style="width: 25%;padding: 0 20px 0 0;vertical-align: top;">';

            $email_content .= '<a href="' . get_the_permalink($single_result->ID) . '"><img style="width: 100%;text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;" src="' . esc_url(get_the_post_thumbnail_url($single_result->ID, 'one-large')) . '" alt="' . $single_result->post_title . '>" title="' . $single_result->post_title . '" /></a>
                                            </td>';

            $email_content .= '<td style="padding: 0 0 10px 10px; width:75%">
                                                <p style="margin-top: 0"><strong><a class="text-para" style="color: inherit;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($single_result->ID) . '">' . $single_result->post_title . '</a></strong></p>
                                                <p>';

            if (!empty($single_result->post_excerpt)) {
                $paragraph = $single_result->post_excerpt;
            } else {
                $paragraph = '';
                $str = $single_result->post_content;
                $str = strip_tags($str);
                $paragraph = substr($str, 0, 200);
                $paragraph = rtrim($paragraph, '.') . '...';
            }
            $para = $paragraph;
            $email_content .= $para . ' <a style="color:#04a353;font-weight:600;text-decoration:none;font-size:16px;font-weight:400;" href="' . get_the_permalink($single_result->ID) . '">Read More</a>';

            $email_content .= "</p>
                                            </td>
                                        </tr>
                                    </table>";
        }
    }

    if ($blogs_available) {

        $email_content .= '<table border="0" width="100%" style="width:100%; text-align: center;">
                                    <tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;padding:5px 30px;background-color : #04a353;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;border-radius:3px;" href="' . site_url('reading-list') . '">  Read more Blogs   </a></p></td></tr>
                                </table>';
    }

    $query = "SELECT * FROM {$wpdb->prefix}posts p LEFT JOIN {$wpdb->prefix}postmeta pm ON p.id = pm.post_id AND pm.meta_key LIKE 'post_views_count' WHERE post_date >= '" . $start_date . "' AND post_date <= '" . date('Y-m-t') . "' AND post_type IN ('news') AND post_status = 'publish' GROUP BY WEEKOFYEAR(post_date) ORDER BY pm.meta_value DESC, p.post_date ASC LIMIT 0, 5";
    $results = $wpdb->get_results($query);
	
	if(!empty($results)){
		
		$email_content .= '<table width=100% border=0 style="margin: 30px 0 30px 0;background-color:#EBEEEF;border-top: 2px solid #04a353;">
						<tbody>
							<tr>
								<td style="width:100%;font-weight: bold;font-size: 25px;padding: 10px 15px;">Top News</td>
							</tr>
						</tbody>
					</table>';

		$email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%">';

		foreach ($results as $result) {
			$email_content .= '<tr style="vertical-align: top;"><td style=" width:100%;padding: 0"><p style="margin-top: 0;font-size:20px;color:#04a353"><strong><a class="text-para" style="color: #04a353;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p></td></tr>';
		}

		$email_content .= '</table>';

		$email_content .= '<table border="0" width="100%" style="width:100%; text-align: center;border-top:1px solid #ddd">
								<tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;margin-top:20px;padding:5px 30px;background-color : #04a353;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;border-radius:3px;" href="' . site_url('news') . '">  More News </a></p></td></tr>
							</table>';
						
	}
	
	/*Ends newsletter_monthly_func : comments*/

	/*Starts monthly newsletter above content HTML : comments*/
	
		$above_content = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
                        *  {
                            font-family: Helvetica,Arial,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol;
                            color: #333333;
                        }
                        h3 {
                            font-family: Helvetica,Arial,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol;
                        }
                        body {
                            -webkit-text-size-adjust:100%;
                            -ms-text-size-adjust:100%;
                            max-width:720px;
                            margin: 0 auto;
                        }

                        body,table,td,a{ 
                            font-size: 15px;
                            line-height: 28px;
                        }
                        table, td{
                            mso-table-lspace:0;
                            mso-table-rspace:0;
                        }
                        img{
                            -ms-interpolation-mode:bicubic;
                            border:0;
                            height:auto;
                            line-height:100%;
                            outline:0;
                            text-decoration:none;
                        }
                        table{
                            border-collapse:collapse!important
                        }
                        a[x-apple-data-detectors]{
                            color:inherit!important;
                            text-decoration:none!important;
                            font-size:inherit!important;
                            font-family:inherit!important;
                            font-weight:inherit!important;
                            line-height:inherit!important
                        }
                        u+#body a{
                            color:inherit;
                            text-decoration:none;
                            font-size:inherit;
                            font-family:inherit;
                            font-weight:inherit;
                            line-height:inherit
                        }
                        #MessageViewBody a{
                            color:inherit;
                            text-decoration:none;
                            font-size:inherit;
                            font-family:inherit;
                            font-weight:inherit;
                            line-height:inherit
                        }

                        a{
                            color:#04a353;
                            font-weight:600;
                            text-decoration:none;
                        }
                        a:hover{
                            color:#000000;
                            text-decoration:underline!important
                        }
                        .h-resize20px {
                            height:20px !important;
                        }
                        .lh40 {
                            line-height:40px !important
                        }
                        .text32 {
                            font-size:32px !important
                        }
                        .w-resize85 {width:85% !important; }
                        .main-div {
                            color:#2b2b2b;
                            font-family:Helvetica,Arial,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol;
                            font-size:18px;
                            font-weight:400;
                            line-height:28px;
                            margin:0 auto;
                            padding:0 20px 40px 20px;
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
                            background-color: #04a353;
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
                            text-decoration: none !important;
                        }

                        a.text-para {
                            color: inherit;
                            text-decoration: none;
                            font-weight: inherit;
                            font-size: inherit;
                        }
                        @media screen and (min-width:600px){
                            h1 {
                                font-size:48px!important;
                                line-height:48px!important
                            }
                            .intro {
                                font-size:24px!important;
                                line-height:36px!important
                            }
                        }
                        @media screen and (max-width:600px){
                            .single-row-news td {
                                width: 100% !important;
                                display: block;
                                padding: 0 !important;
                            }
                            .single-row-news {
                                margin-bottom: 20px;
                            }

                            .head-col1 {
                                width: 100% !important;
                                display: block !important;
                            }
                            .head-col2 {
                                width: 100% !important;
                                display: block !important;
                                text-align: left !important;
                                padding-bottom: 10px !important;
                            }
                            .head-col2 span {
                                left: 0 !important;
                                top: 25px !important;
                            }
                        }
                    </style>
                    <!--user entered Head Start-->

                    <!--End Head user entered-->
                    </head>
                    <body style="-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;max-width:720px;margin: 0 auto;font-size: 15px;line-height: 28px;color: #333333;">

                        <div lang="en" role="article" aria-label="An email from '.get_bloginfo('name').'">

                            <!--[if (gte mso 9)|(IE)]>
                            <table cellspacing=0 cellpadding=0 border=0 width=720 align=center role=presentation><tr><td>
                            <![endif]-->
                            <div role=article aria-label="An email from '.get_bloginfo('name').'" lang=en class="main-div" style="font-weight:400;margin:0 auto;padding:0 20px 40px 20px;color: #333333;">

                                <table width=100% border=0 style="margin-bottom: 0;">
                                    <tbody>
                                        <tr>
                                            <td class="head-col1" height=50 style="width:100%;padding: 0 0 0px 0;width:60%"><img src="https://techversions.com/wp-content/uploads/2020/02/Image20200212125837-1.png" alt="'.get_bloginfo('name').'" style="text-align:center;-ms-interpolation-mode:bicubic;border:0;height:auto;line-height:100%;outline:0;text-decoration:none; max-width: 100%;max-height: 100%;display: block;margin-bottom: 15px;" />
                                            </td>
                                            <td class="head-col2" height=50 style="width:100%;padding: 10px 0 0 0;width:40%;text-align:right;position: relative;"><h2 style="color:#7F8182;font-size:30px;font-family:Gelasio;margin:0">'.$monthly_subject.'</h2>
                                                <span style="position: absolute; top:40px;right:0;color: #7F8182;font-size: 12px;">{{{month}}}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>';
		/*Ends monthly newsletter above content HTML : comments*/
		
		/*Starts monthly newsletter below content HTML : comments*/								
		$below_content = ' <!--START - FOOTER-->
        <table class="module" role="module" data-type="social" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;background-color: #ebeeef;margin-top:20px " data-muid="74ca2758-9d56-4d9f-971a-e02b9cc8d326">
        <tbody>
        
            <tr>
            <td><h3 style="text-align:center;color:#04a353;margin:10px 0 20px 0;padding:20px 0px 0px 0px;">Follow us on</h3></td>
            </tr>
            <tr>
                <td valign="top" style="" align="center">
                    <table align="center" style="-webkit-margin-start:auto;-webkit-margin-end:auto;">
                        <tbody><tr align="center"><td style="padding: 0px 5px;" class="social-icon-column">
                                    <a role="social-icon-link" href="https://www.facebook.com/techversions/" target="_blank" alt="Facebook" title="Facebook" style="">
                                        <img role="social-icon" alt="Facebook" title="Facebook" src="https://techversions.com/assets/facebook.png" />
                                    </a>
                                </td><td style="padding: 0px 5px;" class="social-icon-column">
                                    <a role="social-icon-link" href="https://twitter.com/tech_versions" target="_blank" alt="Twitter" title="Twitter">
                                        <img role="social-icon" alt="Twitter" title="Twitter" src="https://techversions.com/assets/twitter.png" />
                                    </a>
                                </td><td style="padding: 0px 5px;" class="social-icon-column">
                                    <a role="social-icon-link" href="https://www.linkedin.com/company/tech-versions/" target="_blank" alt="LinkedIn" title="LinkedIn">
                                        <img role="social-icon" alt="LinkedIn" title="LinkedIn" src="https://techversions.com/assets/linkedin.png" />
                                    </a>
                                </td></tr></tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
                                <table border="0" cellspacing="0" cellpadding="10" style="background-color:#ebeeef;width: 100%">
                                    <tr>
                                    </tr>
                                    <tr>
                                        <td style="text-align: center;color:#04a353">

                                            <p>
                                                <a style="font-size: 13px;color:#04a353;font-weight : 600;text-decoration : none;" href="/contact-us/">Contact Us</a>
                                                <br />
                                                <a style="font-size: 13px;color:#04a353;font-weight : 600;text-decoration : none;" href="/terms-of-service/">Terms of service</a>
                                                <br/>
                                                <a style="font-size: 13px;color:#04a353;font-weight : 600;text-decoration : none;" href="/privacy-policy/">Privacy Policy</a>
                                                <br/>
                                                <a href="'.site_url('my-account/email-preferences').'" style="font-size: 13px;color:#04a353;font-weight : 600;text-decoration : none;">Manage Your Preferences</a>
                                                <br/>
                                                <a href="<%asm_group_unsubscribe_raw_url%>" style="font-size: 13px;color : #04a353;font-weight : 600;text-decoration : none;">Unsubscribe</a>
                                            </p>
                                            <address style="font-size: 13px; font-style: normal; font-weight: 400; line-height: 24px; color:#7F8182;width: 70%;margin: 30px auto 20px auto;">&copy; '.date('Y').' '.get_bloginfo('name').'. All rights reserved.<br/> 8000 Towers Crescent Drive, 13th Floor, Vienna,VA 22182, USA</address>
                                            <address style="font-size: 12px; font-style: normal; font-weight: 400; line-height: 24px; color:#7F8182">This newsletter cannot be copied, distributed, or displayed without prior written permission from '.get_bloginfo('name').'.</address>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <!--[if (gte mso 9)|(IE)]>
                            </td></tr></table>
                            <![endif]-->
                        </div>
                    </body>
                    </html>';
					
		/*Ends monthly newsletter above content HTML : comments*/
		
		$body = $above_content.$email_content.$below_content;
		
		echo $body;
		
		if(isset($_GET['sendgrid']) && $_GET['sendgrid'] == 'send'){
				
			$dynamic_template_id = sendgridController::SG_DYNAMIC_EMAIL_TEMPLATES['newsletter_monthly'];
			$response = sendgridController::send_newsletter_test($dynamic_template_id, sendgridController::SG_UNSUBSCRIBE_GROUPS['monthly'], array(
					'email_content' => $email_content,
					'brand_name' => get_bloginfo('name'),
					'home_url' => home_url(),
					'newsletter_title' => $monthly_subject,
					'top_news' => $top_news,
					'privacy_policy_url' => site_url('privacy-policy'),
					'terms_of_service_url' => site_url('terms-of-service'),
					'contact_us_url' => site_url('contact-us'),
					'blogs_url' => site_url('blogs'),
					'facebook_link' => esc_attr(get_option('facebook_link')),
					'twitter_link' => esc_attr(get_option('twitter_link')),
					'linkedin_link' =>  esc_attr(get_option('linkedin_link')),
					'instagram_link' =>  esc_attr(get_option('instagram_link')),
					'month' => date('F') . ', ' . date('Y'),
					'curr_year' => date('Y'),
					'manage_your_preferences_link' => site_url('my-account/email-preferences'),
				), 'monthly');

			exit();
		
		}else{
		
			// wp_mail( $tester_email, get_bloginfo('name').' | '.$monthly_subject, $body );
		
		}
		
	}else{
		
		echo '<h2>Please select a newsletter to preview and send</h2><br>';
		
	}	
	
	exit;
}

?>