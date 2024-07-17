<?php
/* Template Name: Landing Page - 2 Template
 * Template Post Type: post, resources
 *  */
get_header();
global $content_width;

$content_width = 1068;
$download_resource_id = get_post_meta($post->ID, 'sdm_description', true);

$pdf_tracker = get_post_meta($post->ID, 'thankyoupage-pdftracker', true);
$thankyoupage_asset = get_post_meta($post->ID, 'thankyoupage-asset', true);

$current_user = wp_get_current_user();
$job_title = get_user_meta($current_user->ID, 'user_registration_job_title', true);
$company_name = get_user_meta($current_user->ID, 'user_registration_company_name', true);


$categories = get_the_terms($post->ID, 'resource_types');
$category = array_pop($categories);
//echo '<pre>';
//print_r($category);
//echo '</pre>';

$thankyou_redirect_url = get_post_meta($post->ID, 'thankyoupage_redirecturl', true);
$thankyoupage_asset = get_post_meta($post->ID, 'thankyoupage_asset', true);
$form_id = get_post_meta( get_the_ID(), 'form-shortcode', true);
$show_related_resources = get_post_meta($post->ID, 'show_related_resources', true);
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
                <div class="row2 wpb_column vc_column_container vc_col-sm-12">
                    <span style="" class="lp-resource-type"><?php echo $category->name; ?></span></div>
                <h1 class="page-h1-head row2-head"><?php echo get_the_title(); ?></h1>

                <div class="row2 wpb_column vc_column_container vc_col-sm-12" style="">
                    <div class="row2-col1 column wpb_column vc_column_container vc_col-sm-6 vc_col-xs-12" style="">

                        <img src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'medium_large')) ?>" alt="<?php the_title_attribute() ?>" /> 
						
						<div style="margin-bottom:5px;margin-top:5px;"></div>

                        <div class='row2-content' style="">
                           <!-- <ul class="td-category" style="margin-top: 10px;margin-bottom: 10px;margin-left:0px;">
                                <?php
                               /* $categories = get_the_category();
                                if (!empty($categories)) {
                                    foreach ($categories as $category) {
                                        $cat_link = get_category_link($category->cat_ID);
                                        $cat_name = $category->name;
                                        ?>
                                        <li class="entry-category">
										 <a href="<?php echo esc_url($cat_link) ?>"><?php echo esc_html($cat_name) ?></a>
										</li>
                                    <?php }
                                } */
                                ?>
                            </ul> -->
                            <?php the_content(); ?>
                             <div style="font-size: 11px;font-style: italic;margin-top: 50px;"><?php echo "Sponsored by: " . $sponsored_name ?></div>
                            <?php
                            // tags
                            //$td_post_tags = get_the_tags();
                            //if (!empty($td_post_tags)) {
                                ?>
                               <!-- <div class="td-post-source-tags">
                                    <ul class="td-tags td-post-small-box clearfix">
                                        <li><span><?php //esc_html_e('TAGS', 'newspaper') ?></span></li>
                                        <?php //foreach ($td_post_tags as $td_post_tag) { ?>
                                            <li class="new-cat"><a href="<?php //echo esc_url(get_tag_link($td_post_tag->term_id)) ?>"><?php //echo esc_html($td_post_tag->name) ?></a></li>
                                <?php //} ?>
                                    </ul>
                                </div> -->
<?php //} ?>
                        </div>
                    </div>
					<div class="vc_col-sm-1">
					</div>
                    <div class="row2-col2 wpb_column vc_column_container vc_col-sm-5 vc_col-xs-12 column" style="border: 1px solid #777a72;padding: 20px 20px 0 20px;">
                        <div class="inner-col2">
						
						 <p style="font-size: 12px;" class="fastpass-info alert alert-info">
                                <!--<span class="tooltip-info">-->
                                    <i class="fa fa-info-circle"  data-toggle="tooltip" data-placement="top" title="" data-original-title="The Fastpass test helps you check for accessibility compliance requirements and issues on the landing page."></i>
                                    <!--<span class="tooltiptext"></span>-->
                                        
                                <!--</span>-->
                                &nbsp; This page is FastPass tested and is compliant with Microsoft Accessibility features.
                            </p>
						
                            <h4 id="lp-form-head" style='font-weight: bold;font-size: 1.5rem;margin-left: 8px;'>Get Exclusive Access to the <?php echo $category->name; ?></h4>
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
                                    echo do_shortcode('[Form id="2"]'); ?>
                                    <?php if (!empty($sponsored_url)) { ?>
                            <span id="privacy_policy" style="margin-bottom: 20px;margin-top: 0px;font-size:12px;line-height: 1.5;"><input type="checkbox" required="required">

                                        By downloading this publication, you understand and agree that you are providing your personal information to Anteriad, LLC, and Anteriad may share your personal information with <?php echo $sponsored_name; ?>, pursuant to Anteriad's <a href="https://anteriad.com/privacy-policy/" target="_blank"> Privacy Policy</a>. Furthermore, <?php echo $sponsored_name; ?> may use your personal information to provide you with marketing materials and contact you regarding its services, pursuant to <a href="<?php echo $sponsored_url; ?>" target="_blank"> Privacy Statement</a>.

                                        <div style="display:none; color:red" id="agree_chk_error">
                                            Sorry! Please accept the terms to proceed.
                                        </div>


                                    <?php } else if (!empty($privacy_policy)) { ?>
                                        <span id="privacy_policy" style="margin-bottom: 20px;margin-top: 0px;font-size:12px;line-height: 1.5;"><input type="checkbox"><?php echo $privacy_policy; ?> 

                                            <div style="display:none; color:red" id="agree_chk_error">
                                                Sorry! Please accept the terms to proceed.
                                            </div>


                                        <?php } else { ?>

                                            <span id="privacy_policy" style="margin-bottom: 20px;margin-top: 0px;font-size:12px;line-height: 1.5;"><input type="checkbox">

                                                By downloading this publication, you understand and agree that you are providing your personal information to Anteriad, LLC, and Anteriad may share your personal information with our clients, pursuant to Anteriad's <a href="https://anteriad.com/privacy-policy/" target="_blank"> Privacy Policy</a>.

                                                <div style="display:none; color:red" id="agree_chk_error">
                                                    Sorry! Please accept the terms to proceed.
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
if($_SESSION['typ_redirect'] == 'true') {
    ?>
<script type="text/javascript">
    toastr["error"]("Please submit the form to access the resource.")

    toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-bottom-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
    </script>
<?php
    unset($_SESSION['typ_redirect']);
}

get_footer();
