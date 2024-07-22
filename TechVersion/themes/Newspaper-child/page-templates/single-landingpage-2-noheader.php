<?php
/* Template Name: Landing Page - 2 - No Header No Footer
 * Template Post Type: post, resources, white_papers, infographics, ebooks
 *  */
get_header('landingpage');
global $content_width;

$content_width = 1068;
$download_resource_id = get_post_meta($post->ID, 'sdm_description', true);

$pdf_tracker = get_post_meta($post->ID, 'thankyoupage-pdftracker', true);

$current_user = wp_get_current_user();
$job_title = get_user_meta($current_user->ID, 'user_registration_job_title', true);
$company_name = get_user_meta($current_user->ID, 'user_registration_company_name', true);
$form_id = get_post_meta( get_the_ID(), 'form-shortcode', true);


$categories = get_the_terms($post->ID, 'resource_types');
$category = array_pop($categories);

$privacy_policy = get_post_meta(get_the_ID(), 'privacy_policy', true);

$primary_sponsor = get_post_meta($post->ID, '_yoast_wpseo_primary_sponsored_by', true);

if(empty($primary_sponsor)) {
    $sponsored_by_arr = get_the_terms($post->ID, 'sponsored_by');
    $primary_sponsor = $sponsored_by_arr[0]->term_id;
}

$sponsored_by = get_term( $primary_sponsor );

$sponsored_by_custom_field = get_option("taxonomy_term_{$primary_sponsor}");
$sponsored_url = $sponsored_by_custom_field['client_url'];
$sponsored_name = $sponsored_by->name;

$sponsored_url_new = $sponsored_by->presenter_id;
?> 
<!-- Conversion Pixel - KPMG_PBCQ_PilotTest1_Pixel2_Q320_08122020 - DO NOT MODIFY -->
<script src="https://secure.adnxs.com/px?id=1305400&t=1" type="text/javascript"></script>
<!-- End of Conversion Pixel -->
<!-- Conversion Pixel - KPMG_PBCQ_PilotTest2_Pixel2_Q320_08172020 - DO NOT MODIFY -->
<script src="https://secure.adnxs.com/px?id=1357981&t=1" type="text/javascript"></script>
<!-- End of Conversion Pixel -->


<style type="text/css">
    .landing-page-2 .inner-col2 {
        /*border: 1px solid #efefef;*/
        padding: 20px 40px 20px 40px;
        /*background-color: #EEEEEE;*/
        height: auto;
        /*box-shadow: 0 0 36px -29px #000!important;*/
        border-radius: 6px;
        box-shadow: 0 24px 40px -12px rgba(50,50,93,.22), 0 12px 18px -8px rgba(0,0,0,.26);
        margin-top: 20px;
    }
    .landing-page-2 .row2 .row2-col2 {
        padding-left: 70px!important;
    }
    .category-title {
        margin: 0 auto 10px auto;
    }
</style>
<div class="td-main-content-wrap td-container-wrap landing-page-template">
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
        <div class="td-pb-span12 td-main-content landing-page-2 landing-page-2-no-header">
            <div class="td-ss-main-content">
                <!-- START -  Row 2-->
                
                <div class="row2" style="">
                    <div class="row2-col1 column" style="">
                        <div class="category-title">
                            <?php if ($category->name != '') { ?>
                                <span style="" class="post-category"><?php echo $category->name; ?></span>
                            <?php } else {
                                
                                $post_types = get_post_type_object( $post->post_type );
                                ?>
                                <span style="background-color:#3A4A3F" class="post-category"><?php echo $post_types->labels->singular_name; ?></span>
                            <?php } ?>
                        </div>
                        <h1 class="page-h1-head" style="max-width:1068px;margin: 0 auto;text-align: left;"><?php echo get_the_title(); ?></h1>
                        <?php
//                        $featured_image = get_the_post_thumbnail_url(null, 'medium_large');
//                        echo '<pre>';
//                        print_r($featured_image);
//                        echo '</pre>';
//                        if ($featured_image) {
                            ?>
                            <!--<img src="<?php echo $featured_image; ?>" />-->
                        <?php // } ?>

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
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                            <?php the_content(); ?>
                            <div class="Sponsored_name"><?php echo "Sponsored by: <b>" . $sponsored_name. "</b>" ?></div>

                            <?php
                            // tags
//                            $td_post_tags = get_the_tags();
//                            if (!empty($td_post_tags)) {
                                ?>
<!--                                <div class="td-post-source-tags">
                                    <ul class="td-tags td-post-small-box clearfix">
                                        <li><span><?php esc_html_e('TAGS', 'newspaper') ?></span></li>
                                        <?php foreach ($td_post_tags as $td_post_tag) { ?>
                                            <li><a href="<?php echo esc_url(get_tag_link($td_post_tag->term_id)) ?>"><?php echo esc_html($td_post_tag->name) ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>-->
                            <?php // } ?>
                        </div>
                    </div>
                    <div class="row2-col2 column" style="">
                        <div class="inner-col2">
                            <?php
                            $form_title = get_post_meta($post->ID, 'form-title', true);
                            ?>
                            <h4 id="lp-form-head" style='font-weight: bold'><?php echo ($form_title == '') ? 'Get Exclusive Access to the White Paper' : $form_title; ?></h4>
                            <div id="lp-form-msg" style="display: none" class="alert alert-success"></div>

                            <span style="display: none;" id="get_resource_id"><?php echo $post->ID . '-' . $download_resource_id; ?></span>
                            <span style="display: none;" id="get_resource_title"><?php echo $post->post_title; ?></span>
                            <?php
                            //If a Landing Page has this variable 'thankyoupage-pdftracker' set to true the thank you page should open with a PDF Tracker
                            if ($pdf_tracker === 'true') {
                                ?>
                                <span style="display: none;" id="set_pdf_tracker">true</span>
                            <?php } ?>
                            <span style="display: none;" id="get_user_name"><?php echo $current_user->first_name; ?></span>
                            <span style="display: none;" id="get_user_email"><?php echo $current_user->user_email; ?></span>
                            <span style="display: none;" id="get_user_company"><?php echo $company_name; ?></span>
                            <span style="display: none;" id="get_user_job_title"><?php echo $job_title; ?></span>
                            <?php  if(!empty($form_id)){
                                    echo do_shortcode('[Form id="'.$form_id.'"]');
                                }else{
                                    echo do_shortcode('[Form id="51"]'); ?>

                                <?php if (!empty($sponsored_url)) { ?>
                            <span class="checkbox-div" id="privacy_policy"><input type="checkbox" required="required">

                                        By downloading this publication, you understand and agree that you are providing your personal information to Anteriad, LLC, and Anteriad may share your personal information with <?php echo $sponsored_name; ?>, pursuant to Anteriad's <a href="https://anteriad.com/privacy-policy/" target="_blank"> Privacy Policy</a>. Furthermore, <?php echo $sponsored_name; ?> may use your personal information to provide you with marketing materials and contact you regarding its services, pursuant to <a href="<?php echo $sponsored_url; ?>" target="_blank"> Privacy Statement</a>.

                                        <div style="display:none; color:red" id="agree_chk_error">
                                            Accept the terms to proceed.
                                        </div>


                                    <?php } else if (!empty($privacy_policy)) { ?>
                                        <span class="checkbox-div" id="privacy_policy"><input type="checkbox"><?php echo $privacy_policy; ?> 

                                            <div style="display:none; color:red" id="agree_chk_error">
                                                Accept the terms to proceed.
                                            </div>


                                        <?php } else { ?>

                                            <span class="checkbox-div" id="privacy_policy"><input type="checkbox">

                                                By downloading this publication, you understand and agree that you are providing your personal information to Anteriad, LLC, and Anteriad may share your personal information with our clients, pursuant to Anteriad's <a href="https://anteriad.com/privacy-policy/" target="_blank"> Privacy Policy</a>.

                                                <div style="display:none; color:red" id="agree_chk_error">
                                                    Accept the terms to proceed.
                                                </div>

                                            <?php } ?>

                                        <?php } ?>
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
<!--<script type="text/javascript">
    jQuery('.button-submit').click( function() { // add the click event handler to button
             Conversion Pixel - KPMG_PBCQ_PilotTest_Pixel2_Q320_08122020 - DO NOT MODIFY 
            <script src="https://secure.adnxs.com/px?id=1305400&t=1" type="text/javascript"></script>
             End of Conversion Pixel 
    });
</script>-->
<?php
get_footer('landingpage');
