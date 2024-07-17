<?php
/* Template Name: Landing Page - 1 Template
 * Template Post Type: post, resources
 *  */
get_header();
global $content_width;

$content_width = 1068;
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
<!-- jQuery Modal -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<!-- Google Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.16.0/css/mdb.min.css" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- JQuery -->
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>


<!-- START Modal: modalPoll -->
<div class="modal fade" id="landing-page1-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-notify modal-info" role="document">
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <p class="heading lead">Get Exclusive Access to the White Paper</p>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">x</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body">
                <div class="text-center">
                    <i class="far fa-file-alt fa-4x mb-3 animated rotateIn"></i>
                    <p>
                        <strong><?php echo get_the_title(); ?></strong>
                    </p>
          <!--          <p>Have some ideas how to improve our product?
                      <strong>Give us your feedback.</strong>
                    </p>-->
                </div>

                <hr>
                <?php echo do_shortcode('[Form id="8"]'); ?>
                <?php if (!empty($sponsored_url)) { ?>
                            <span id="privacy_policy" style="margin-bottom: 20px;margin-top:0px;font-size:12px;line-height: 1.5;"><input type="checkbox" required="required">

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

                                        <?php ?>
            </div>

            <!--Footer-->
            <!--      <div class="modal-footer justify-content-center">
                    <a type="button" class="btn btn-primary waves-effect waves-light">Send
                      <i class="fa fa-paper-plane ml-1"></i>
                    </a>
                    <a type="button" class="btn btn-outline-primary waves-effect" data-dismiss="modal">Cancel</a>
                  </div>-->
        </div>
    </div>
</div>
<!-- END Modal: modalPoll -->
<div class="td-main-content-wrap td-container-wrap landing-page">
    <!--<div class="td-container">-->
<!--        <div class="td-crumb-container">
            <?php
//            echo tagdiv_page_generator::get_breadcrumbs(array(
//                'template' => 'single',
//                'title' => get_the_title(),
//            ));
            ?>
        </div>-->

        <div class="td-pb-row">
            <div class="td-pb-span12 td-main-content">
                <div class="td-ss-main-content landing-page-1">
                    <div class="row2 row2-flex" style="">
                        <div class="row2-col1 column" style="">
                            <span style="font-size: 0.5rem;
                                  line-height: 1.1;
                                  letter-spacing: 0.0625rem;
                                  color: #000;;
                                  font-weight: 700;
                                  background-color: #cecece;
                                  padding: 4px 6px;
                                  border-radius: 3px;">WHITE PAPER</span>
                            <h1 class="page-h1-head"><?php echo get_the_title(); ?></h1>

                            <?php the_content(); ?>
                             <div style="font-size: 11px;font-style: italic;margin-top: 50px;"><?php echo "Sponsored by: " . $sponsored_name ?></div>
                            <p><a href='javascript:' id='get-details-btn' class='btn7 download-btn-border'>Download</a></p>
                        </div>
                        <div class="row2-col2 column" style=""><img src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'medium_large')) ?>" /></div>
                        <div class="clearfix"></div>
                    </div>

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

<?php get_footer();