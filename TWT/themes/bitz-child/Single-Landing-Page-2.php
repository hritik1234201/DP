<?php
/* Template Name: Landing Page */
get_header();
global $content_width;

$content_width = 1068;
$download_resource_id = get_post_meta($post->ID, 'sdm_description', true);

//$pdf_tracker = get_post_meta($post->ID, 'thankyoupage-pdftracker', true);

$current_user = wp_get_current_user();
$job_title = get_user_meta($current_user->ID, 'user_registration_job_title', true);
$company_name = get_user_meta($current_user->ID, 'user_registration_company_name', true);


$categories = get_the_terms($post->ID, 'resource_types');
$category = array_pop($categories);
?> 

<?php

$custom = get_post_custom();
$test = array($custom);

//print_r($test);

//print $test[20];

$cats =  get_post_meta(get_the_ID(), 'Custom_Tag', TRUE);
print "<div style='color: #ec2327;text-align: left;font-family:Averia Serif Libre;font-weight:400;font-style:normal'>" . $cats . "</div>";


foreach($custom as $key => $value) {
     //print_r ($key.': '.$value.'<br />');
	 //$key = array_search ('Custom_Tag', $get);
	 //print_r($key . "key");
//print_r ($value . "value");
	 
	 //print_r($value);
}

?>

<div class="td-main-content-wrap td-container-wrap landing-page">
    <!--<div class="td-container">-->
    <!--<div class="td-crumb-container">-->
    <?php
//            echo tagdiv_page_generator::get_breadcrumbs(array(
//                'template' => 'single',
//                'title' => get_the_title(),
//            ));
    ?>
    <!--</div>-->

    <div class="td-pb-row">
        <div class="td-pb-span12 td-main-content landing-page-2">
            <div class="td-ss-main-content">
                <!-- START -  Row 2-->
                <div style="width:80%;margin: 30px auto 10px auto;">
                    <span style="" class="lp-resource-type"><?php echo $category->name; ?></span></div>
                <h1 class="page-h1-head row2-head" style=""><?php echo get_the_title(); ?></h1>

                <div class="wpb_column vc_column_container vc_col-sm-12" style="">
                    <div class="wpb_column vc_column_container vc_col-sm-6 vc_col-xs-12" style="">

                        <img src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'medium_large')) ?>" />

                        <div class='row2-content' style="">
                            <ul class="td-category" style="margin-top: 10px;margin-bottom: 10px;">
                                <?php
                                $categories = get_the_category();
                                if (!empty($categories)) {
                                    foreach ($categories as $category) {
                                        $cat_link = get_category_link($category->cat_ID);
                                        $cat_name = $category->name;
                                        ?>
                                        <li class="entry-category"><a href="<?php echo esc_url($cat_link) ?>"><?php echo esc_html($cat_name) ?></a></li>
                                    <?php }
                                } 
                                ?>
                            </ul>
                            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php the_content(); ?>
<?php endwhile; endif; ?>

<ul style="margin-left:0px" class="Same-line td-tags td-post-small-box clearfix">
<li><a href="https://staging.leadslines.com/resources/#white-paper">White Paper</a></li>
<li><a href="https://staging.leadslines.com/resources/#Ebook">Ebook</a></li>
<li><a href="https://staging.leadslines.com/resources/#infographic">Infographic</a></li>
</ul>

<?php echo do_shortcode('[DISPLAY_ULTIMATE_SOCIAL_ICONS]'); ?>

                            <?php
                            // tags
                            $td_post_tags = get_the_tags();
                            if (!empty($td_post_tags)) {
                                ?>
                                <div class="td-post-source-tags">
                                    <ul class="td-tags td-post-small-box clearfix">
                                        <li><span><?php esc_html_e('TAGS', 'newspaper') ?></span></li>
                                        <?php foreach ($td_post_tags as $td_post_tag) { ?>
                                            <li><a href="<?php echo esc_url(get_tag_link($td_post_tag->term_id)) ?>"><?php echo esc_html($td_post_tag->name) ?></a></li>
                                <?php } ?>
                                    </ul>
                                </div>
<?php } ?>
                        </div>
                    </div>
					<div class="vc_col-sm-1">
					</div>
                    <div class="wpb_column vc_column_container vc_col-sm-5 vc_col-xs-12" style="border: 1px solid #f6f6f6;padding-left:35px;">
                        <div class="inner-col2" style="padding: 25px;box-shadow: 0px 0px 0px 0px #888888;">
                            <h4 id="lp-form-head" style='font-weight: bold'>Get Exclusive Access to the White Paper</h4>
                            <div id="lp-form-msg" style="display: none" class="alert alert-success"></div>
                            
							
							
                            <span style="display: none;" id="get_resource_id"><?php echo $post->ID . '-' . $download_resource_id; ?></span>
                            <span style="display: none;" id="get_resource_title"><?php echo $post->post_title; ?></span>
                            <?php
                            //If a Landing Page has this variable 'thankyoupage-pdftracker' set to true the thank you page should open with a PDF Tracker
                            //if($pdf_tracker === 'true') {
                            ?>
                            <!-- <span style="display: none;" id="set_pdf_tracker">true</span> -->
                            <?php //} ?>
                            <span style="display: none;" id="get_user_name"><?php echo $current_user->first_name; ?></span>
                            <span style="display: none;" id="get_user_email"><?php echo $current_user->user_email; ?></span>
                            <span style="display: none;" id="get_user_company"><?php echo $company_name; ?></span>
                            <span style="display: none;" id="get_user_job_title"><?php echo $job_title; ?></span>
                            <?php echo do_shortcode('[Form id="2"]'); ?>
							
                        </div>
                    </div>
                    
                </div>
                <!-- END -  Row 2-->

                <div class="clearfix"></div>
                <?php
//                        get_template_part('loop-single' );
//                        comments_template('', true);
                ?>
                

            </div>
        </div>
    </div>
    <!--</div>-->
</div>

<?php
get_footer();
