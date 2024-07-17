<?php
function newsletter_daily_func() {

    global $wpdb;
    $top_news = '';
    $query = "SELECT * FROM `".$wpdb->prefix."posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_date < '" . date('Y-m-d') . "' AND post_type IN ('news') AND post_status = 'publish' ORDER BY `".$wpdb->prefix."posts`.`post_date` DESC LIMIT 0, 1";
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
                                                <p><a class="link-btn" style="background-color: #ff7500;color: #FFF;font-size: 11px !important;line-height: 35px !important;letter-spacing: 1px !important;height: auto;border-radius: 1px;padding: 0 16px;box-sizing: border-box;text-decoration: none;display: inline-block;" href="' . get_the_permalink($result->ID) . '"> Read More </a></p>
                                            </td>
                                        </tr>
                                    </table>';

	}
	
//Second Row
    $query = "SELECT * FROM `".$wpdb->prefix."posts` WHERE post_date >= '" . date('Y-m-d 11:00', strtotime('-1 day')) . "' AND post_date < '" . date('Y-m-d 10:59') . "' AND post_type IN ('news') AND post_status = 'publish' ORDER BY `".$wpdb->prefix."posts`.`post_date` DESC LIMIT 1, 4";
    $results = $wpdb->get_results($query, OBJECT);

    foreach ($results as $result) {

        $email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom: 20px;">
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
        }
        $para = $paragraph;
        $email_content .= $para . ' <a  style="color:#ff7500;text-decoration:none;font-size:15px;font-weight:400;"  href="' . get_the_permalink($result->ID) . '">Read More</a>';
        $email_content .= '</p>
                                            </td>
                                        </tr>
                                    </table>';
    }

    $query = "SELECT * FROM `".$wpdb->prefix."posts` WHERE post_type IN ('news') AND post_status = 'publish' ORDER BY `".$wpdb->prefix."posts`.`post_date` DESC LIMIT 5, 3";
    $results = $wpdb->get_results($query, OBJECT);
	
	if(!empty($results)){
		$email_content .= '<table width=100% border=0 style="margin: 30px 0;margin-bottom: 20px;">
								<tbody>
									<tr>
										<td style="width:100%;border-bottom: 1px solid #ddd;padding: 0 0 10px 0;font-weight: bold;font-size: 20px">In case you missed it</td>
									</tr>
								</tbody>
							</table>';
	}
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
        $email_content .= $para . ' <a style="color:#ff7500;text-decoration:none;font-size:15px;font-weight:400;" href="' . get_the_permalink($result->ID) . '">Read More</a>';
        $email_content .= '</p>
                                            </td>
                                        </tr>
                                    </table>';
    }

    $dynamic_template_id = sendgridController::SG_DYNAMIC_EMAIL_TEMPLATES['newsletter_daily'];
	
    if (!empty($top_news)) {
        $response = sendgridController::send_newsletter($dynamic_template_id, sendgridController::SG_UNSUBSCRIBE_GROUPS['daily'], array(
                    'email_content' => $email_content,
                    'current_date' => date('l, F j, Y'),
					'curr_year' => date('Y'),
					'brand_name' => get_bloginfo('name'),
					'newsletter_title' => ti_daily_unsub_title,
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
}
add_action('newsletter_daily', 'newsletter_daily_func');

function newsletter_weekly_func() {
   
	global $wpdb;

    $query = "SELECT * FROM `".$wpdb->prefix."posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_type IN ('news') AND post_status = 'publish' ORDER BY `".$wpdb->prefix."posts`.`post_date` ASC LIMIT 0, 1";
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
                                                <p><a class="link-btn" style="background-color: #ff7500;color: #FFF;font-size: 11px !important;line-height: 35px !important;letter-spacing: 1px !important;height: auto;border-radius: 1px;padding: 0 16px;box-sizing: border-box;text-decoration: none;display: inline-block;" href="' . get_the_permalink($result->ID) . '"> Read More </a></p>
                                            </td>
                                        </tr>
                                    </table>';
	}

//Second Row
    $query = "SELECT * FROM `".$wpdb->prefix."posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_type IN ('news') AND post_status = 'publish' ORDER BY `".$wpdb->prefix."posts`.`post_date` ASC LIMIT 1, 4";
    $results = $wpdb->get_results($query, OBJECT);

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
        $email_content .= $para . ' <a style="color:#ff7500;font-weight:600;text-decoration:none;font-size:15px;font-weight:400;" href="' . get_the_permalink($result->ID) . '">Read More</a>';
        $email_content .= '</p>
                                            </td>
                                        </tr>
                                    </table>';
    }

    $email_content .= '<table border="0" width="100%" style="width:100%; text-align: center">
                                    <tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;margin-top:20px;padding:5px 30px;background-color : #ff7500;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;" href="' . site_url('news') . '">  Click here for more news  </a></p></td></tr>
                                </table>';


//START -- Resource ROw

    $query = "SELECT * FROM `".$wpdb->prefix."posts` WHERE post_date >= '" . date('Y-m-d', strtotime('-1 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "' AND post_type IN ('resources') AND post_status = 'publish' ORDER BY `".$wpdb->prefix."posts`.`post_date` ASC LIMIT 1, 3";
    $results = $wpdb->get_results($query, OBJECT);
	
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
					. '<p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;margin-top:20px;padding:5px 30px;background-color : #ff7500;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;" href="' . get_the_permalink($result->ID) . '">Download for free</a></p>'
					. '</td>';
			$i++;
		}
		$email_content .= ' </tr>
						</table>';
										
	}

    $query = "SELECT * FROM `".$wpdb->prefix."posts` WHERE post_type IN ('post') AND post_date >= '" . date('Y-m-d', strtotime('-1 week')) . "' AND post_date < '" . date('Y-m-d', strtotime('-1 day')) . "'  AND post_status = 'publish' ORDER BY `".$wpdb->prefix."posts`.`post_date` ASC LIMIT 0, 3";
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
			$email_content .= $para . ' <a style="color:#ff7500;text-decoration:none;font-size:15px;font-weight:400;" href = "' . get_the_permalink($result->ID) . '">Read More</a>';
			$email_content .= '</p>
										</td>
										</tr>
										</table>';
		}
		
	}

    $dynamic_template_id = sendgridController::SG_DYNAMIC_EMAIL_TEMPLATES['newsletter_weekly'];

    if (!empty($todays_post)) {
        $response = sendgridController::send_newsletter($dynamic_template_id, sendgridController::SG_UNSUBSCRIBE_GROUPS['weekly'], array(
                    'email_content' => $email_content,
                    'curr_year' => date('Y'),
					'brand_name' => get_bloginfo('name'),
					'newsletter_title' => ti_weekly_unsub_title,
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
}
add_action('newsletter_weekly', 'newsletter_weekly_func');

function newsletter_monthly_func() {
	
    if (date('Y-m-d') !== date('Y-m-t')) {
        exit(0);
    }
    
	$start_date = date('Y-m-01');

    global $wpdb;

    //START -- Resources -- Row 1
    $query = "SELECT * FROM `{$wpdb->prefix}posts` as p LEFT JOIN {$wpdb->prefix}postmeta pm ON p.id = pm.post_id AND pm.meta_key LIKE 'post_views_count'  WHERE post_date >= '" . $start_date . "' AND post_date < '" . date('Y-m-t') . "' AND post_type IN ('resources') AND post_status = 'publish' GROUP BY WEEKOFYEAR(post_date) ORDER BY p.`post_date` ASC LIMIT 0, 4";

    $results = $wpdb->get_results($query, OBJECT);
	
	if(!empty($results)){
		
	    $email_content .= '<table width=100% border=0 style="margin: 0 0 20px 0;background-color:#ebeeef;border-top: 2px solid #ff7500;">
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
					. '<p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;margin-top:5px;padding:5px 30px;background-color : #ff7500;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;border-radius:3px;" href="' . get_the_permalink($result->ID) . '">Download for free</a></p>'
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
        $email_content .= '<table width=100% border=0 style="margin: 0px 0 30px 0;background-color:#EBEEEF;border-top: 2px solid #ff7500;">
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
            $email_content .= $para . ' <a style="color:#ff7500;font-weight:600;text-decoration:none;font-size:16px;font-weight:400;" href="' . get_the_permalink($single_result->ID) . '">Read More</a>';

            $email_content .= "</p>
                                            </td>
                                        </tr>
                                    </table>";
        }
    }

    if ($blogs_available) {

        $email_content .= '<table border="0" width="100%" style="width:100%; text-align: center;">
                                    <tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;padding:5px 30px;background-color : #ff7500;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;border-radius:3px;" href="' . site_url('reading-list') . '">  Read more Blogs   </a></p></td></tr>
                                </table>';
    }

    $query = "SELECT * FROM {$wpdb->prefix}posts p LEFT JOIN {$wpdb->prefix}postmeta pm ON p.id = pm.post_id AND pm.meta_key LIKE 'post_views_count' WHERE post_date >= '" . $start_date . "' AND post_date <= '" . date('Y-m-t') . "' AND post_type IN ('news') AND post_status = 'publish' GROUP BY WEEKOFYEAR(post_date) ORDER BY pm.meta_value DESC, p.post_date ASC LIMIT 0, 5";
    $results = $wpdb->get_results($query);
	
	if(!empty($results)){
		
		$email_content .= '<table width=100% border=0 style="margin: 30px 0 30px 0;background-color:#EBEEEF;border-top: 2px solid #ff7500;">
						<tbody>
							<tr>
								<td style="width:100%;font-weight: bold;font-size: 25px;padding: 10px 15px;">Top News</td>
							</tr>
						</tbody>
					</table>';

		$email_content .= '<table class="single-row-news" border="0" cellspacing="0" cellpadding="0" style="width: 100%">';

		foreach ($results as $result) {
			$email_content .= '<tr style="vertical-align: top;"><td style=" width:100%;padding: 0"><p style="margin-top: 0;font-size:20px;color:#ff7500"><strong><a class="text-para" style="color: #ff7500;text-decoration: none;font-weight: inherit;font-size: inherit;" href="' . get_the_permalink($result->ID) . '">' . $result->post_title . '</a></strong></p></td></tr>';
		}

		$email_content .= '</table>';

		$email_content .= '<table border="0" width="100%" style="width:100%; text-align: center;border-top:1px solid #ddd">
								<tr><td><p><a class="link-btn" style="text-decoration: none; font-size: 15px;color:#FFF;margin-top:20px;padding:5px 30px;background-color : #ff7500;line-height : 35px !important ;letter-spacing : 1px !important ;height : auto;border-radius : 1px;box-sizing : border-box;text-decoration : none;display : inline-block;border-radius:3px;" href="' . site_url('news') . '">  More News </a></p></td></tr>
							</table>';
						
	}
    
    $dynamic_template_id = sendgridController::SG_DYNAMIC_EMAIL_TEMPLATES['newsletter_monthly'];
    $response = sendgridController::send_newsletter($dynamic_template_id, sendgridController::SG_UNSUBSCRIBE_GROUPS['monthly'], array(
                'email_content' => $email_content,
				'brand_name' => get_bloginfo('name'),
				'home_url' => home_url(),
				'newsletter_title' => ti_monthly_unsub_title,
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
}
add_action('newsletter_monthly', 'newsletter_monthly_func');
?>