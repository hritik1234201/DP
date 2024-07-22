<?php
$post_count = 1;
$column_count = 1;

$span = 'span4';
$column_break = 3;
$is_404 = false;
if (is_404()) {
    $is_404 = true;
    $column_break = 3;
    $span = 'span4';

    $args = array(
        'post_type' => 'post',
        'showposts' => 6,
        'ignore_sticky_posts' => true
    );
    query_posts($args);
}
//global $wpdb;
//$post_types = get_post_type_object( $post->post_type );

$download_resource_id = get_post_meta($post->ID, 'sdm_description', true);


    if (preg_match('/"([^"]+)"/', $download_resource_id, $m)) {
        $download_resource_id = $m[1];
    } else {
        $download_resource_id = $download_resource_id;
    }

$pdf_tracker = get_post_meta($post->ID, 'thankyoupage-pdftracker', true);
// $thankyoupage_redirecturl = get_post_meta($post->ID, 'thankyoupage-redirecturl', true);
// $thankyoupage_asset = get_post_meta($post->ID, 'thankyoupage-asset', true);

$thankyou_redirect_url = get_post_meta($post->ID, 'thankyoupage_redirecturl', true);
$thankyoupage_asset = get_post_meta($post->ID, 'thankyoupage_asset', true);

$current_user = wp_get_current_user();
$job_title = get_user_meta($current_user->ID, 'user_registration_job_title', true);
$company_name = get_user_meta($current_user->ID, 'user_registration_company_name', true);

$form_id = get_post_meta( get_the_ID(), 'form-shortcode', true);

$categories = get_the_terms($post->ID, 'resource_types');
$category = array_pop($categories);
$post_types = get_post_type_object($post->post_type);
$show_related_resources = get_post_meta($post->ID, 'show_related_resources', true);
$form_id = get_post_meta( get_the_ID(), 'form-shortcode', true);

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
$title = trim( get_the_title() );

?>

<style type="text/css">
    .landing-page-template .row2{margin: 2% auto 0% auto;}
    .landing-page-2 .inner-col2 {
        /*border: 1px solid #efefef;*/
        padding: 40px 40px 20px 40px;
        /*background-color: #EEEEEE;*/
        height: auto;
        /*box-shadow: 0 0 36px -29px #000!important;*/
        border-radius: 6px;
        box-shadow: 0 24px 40px -12px rgba(50,50,93,.22), 0 12px 18px -8px rgba(0,0,0,.26);
        margin-top: 20px;
    }
    .single span.td-pulldown-size {
    color: #fff;
}
    .landing-page-2 .row2 .row2-col1 {
        /* padding-left: 70px!important; */
        padding-right: 2%;
    }
    .landing-page-2 .row2 .row2-col2 {
        /* padding-left: 70px!important; */
        padding-left: 0px!important;
    }
    .category-title {
        margin: 0 auto 10px auto;
    }



    @media screen and (max-width: 968px) and (min-width: 320px) {
        

        .landing-page-2 .row2 .row2-col1{
            text-align:left !important;
        }
        .landing-page-2 .row2 .row2-col2 {
            padding-left: 0px!important;
        }
    }

    @media screen and (max-width: 1124px) and (min-width: 969px) {
        .landing-page-2 {
            margin: 0;
            padding-left: 40px !important;
            padding-right: 40px !important;
        }

        .landing-page-2 .row2 .row2-col1{
            text-align:left !important;
        }
        .landing-page-2 .row2 .row2-col2 {
            padding-left: 0px!important;
        }
    }




    @media (max-width: 1068px) {
        /* .landing-page-2 {
            margin: 0;
            padding-left: 15px !important;
            padding-right: 15px !important;
        }
                .landing-page-template .row2{
                         padding-left: 10px !important;
                } */
    }

    @media (max-width: 979px) {


        .landing-page-2 .row2 .row2-col1 {
            text-align: left !important;
            border-right: none!important;
            padding-right: 0;
            /* padding-left: 20px; */
        }



        /*	.landing-page-2 .row2 .row2-col2 {
            padding-left: 20px !important;
        } */

    }

    @media only screen and (min-device-width : 320px) and (max-device-width : 768px)  {

        /*.landing-page-2 .row2 .row2-col2 {
            padding-left: 20px !important;
        }*/
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
    <div class="entry-crumbs td-crumb-container breadcrum"><span><a title="" class="tdb-entry-crumb" href="#">Home</a></span><i class="td-icon-right td-bread-sep"></i><span><?php echo $post_types->labels->singular_name; ?></span> <i class="td-icon-right td-bread-sep"></i> <span><?php echo get_the_title(); ?></span> </div>

    <div class="td-pb-row">
        <div class="td-pb-span12 td-main-content landing-page-2">
            <div class="td-ss-main-content">
                <!-- START -  Row 2-->
                <div class="resource-page-title" >
                    <div class="category-title">
                        <?php if ($category->name != '') { ?>
                            <span style="" class="post-category"><?php echo $category->name; ?></span>
                            <?php
                        } else {

                            $post_types = get_post_type_object($post->post_type);
                            ?>
                            <span style="" class="post-category"><?php echo $post_types->labels->singular_name; ?></span>
                        <?php } ?>
                    </div>
                    <h1 class="page-h1-head" style="max-width:1068px;margin: 0 auto;text-align: left;font-weight:900"><?php echo get_the_title(); ?></h1>
                </div>
                <div class="row2" style="">

                    <div class="row2-col1 column" style="">

                        <?php
                        $featured_image = get_the_post_thumbnail_url(null, 'medium_large');
                        if ($featured_image) {
                            ?>
                            <img src="<?php echo $featured_image; ?>" alt="<?php the_title() ?>" style="width:100%;height:400px;object-fit: contain;object-fit: cover;object-position: top left;" />
                        <?php } ?>

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
                            <!--<div class="td-post-source-tags">-->
                            <!--                                    <ul class="td-tags td-post-small-box clearfix">
                                                                    <li><span><?php esc_html_e('TAGS', 'newspaper') ?></span></li>
                            <?php // foreach ($td_post_tags as $td_post_tag) { ?>
                                                                        <li><a href="<?php echo esc_url(get_tag_link($td_post_tag->term_id)) ?>"><?php echo esc_html($td_post_tag->name) ?></a></li>
                            <?php // } ?>
                                                                </ul>-->
                            <!--</div>-->
                            <?php // } ?>
                        </div>
                    </div>
                    <div class="row2-col2 column">
                        <div class="inner-col2" style="margin-top: 0">
                        <p style="font-size: 10px;line-height: 1.5;" class="fastpass-info alert alert-info">
                                <!--<span class="tooltip-info">-->
                                    <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="The Fastpass test helps you check for accessibility compliance requirements and issues on the landing page."></i>
                                    <!--<span class="tooltiptext"></span>-->
                                        
                                <!--</span>-->
                                &nbsp; This page is FastPass tested and is compliant with Microsoft Accessibility features.
                            </p>
                           <?php    $form_title = get_post_meta($post->ID, 'form-title', true);
                            ?>
                            <h4 id="lp-form-head" style='font-weight: bold'><?php echo ($form_title == '') ? 'Get Exclusive Access to the '.$post_types->labels->singular_name : $form_title; ?></h4>
                            <div id="lp-form-msg" style="display: none" class="alert alert-success"></div>
                                <?php
                                //If a Landing Page has this variable 'thankyoupage-pdftracker' set to true the thank you page should open with a PDF Tracker
                                if (!empty($thankyou_redirect_url)) {
                                    ?>
                                    <span style="display: none;" id="set_thankyoupage_redirecturl"><?php echo $thankyou_redirect_url; ?></span>
                                <?php }
                                    if(!empty($download_resource_id)){
                                ?>
                                <span style="display: none;" id="download_resource_id"><?php echo $download_resource_id; ?></span>
                                <?php } if(!empty($thankyoupage_asset)){ ?>
                                    <span style="display: none;" id="set_thankyoupage_asset"><?php echo $thankyoupage_asset; ?></span>
                                    <?php }
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
                            <span style="display: none;" id="get_resource_title"><?php echo $post->post_title; ?></span>
                            <span style="display: none;" id="get_resource_id"><?php echo $post->ID; ?></span>
                            <?php if(!empty($show_related_resources)){?>
                            <span style="display: none;" id="show_related_resources"><?php echo $show_related_resources; ?></span>
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




<?php 
if($title == 'Five Essentials of Modern IT Infrastructure Management'){ ?>
    <script src='https://js.adsrvr.org/up_loader.1.1.0.js' type='text/javascript'></script>
        <script type='text/javascript'>
            ttd_dom_ready( function() {
                if (typeof TTDUniversalPixelApi === 'function') {
                    var universalPixelApi = new TTDUniversalPixelApi();
                    universalPixelApi.init('veme4uw', ['q7ldulc'], 'https://insight.adsrvr.org/track/up');
                }
            });
        </script>
  <?php  }
    ?>