<?php 
/*
 * Template Name: Do Not Sell My Information Template
 */
get_header(); ?>

    <div class="td-main-content-wrap td-container-wrap">
        <div class="td-container">
            <div class="">
                <?php echo tagdiv_page_generator::get_breadcrumbs(array(
                    'template' => 'page',
                    'page_title' => get_the_title(),
                )); ?>
            </div>

            <div class="td-pb-row">
                <div class="td-pb-span12 td-main-content">
                    <div class="td-ss-main-content">
                        <?php
                            if (have_posts()) {
                                while ( have_posts() ) : the_post();
                                    ?>
                                    <div class="td-page-header archive_news">
                                        <h1 class="entry-title td-page-title">
                                            <span><?php the_title() ?></span>
                                        </h1>
                                    </div>
                                    <div class="td-page-content tagdiv-type">
                                        <?php the_content(); ?>
                                        
                                        
                                        <div class="consumer-requests" id="consumer-requests-2">
                                            <h2>Request Removal/Deletion</h2>
                                            <p>Want to remove your existing information from our database? Click the button below. Once you click this button, all the information pertaining to you will be removed from our database on immediate notice.</p>
                                            <!--<button class="btn btn-primary data-request-btn" data-title="Request Removal/Deletion from <?php echo get_bloginfo( 'name' ); ?>" data-type-value="Request Deletion">Request Deletion</button>-->
                                            <a class="btn btn-primary" href="<?php echo site_url('do-not-sell-my-information-request-removal') ?>">Request Deletion</a>
                                        </div>
                                        <div class="consumer-requests" id="consumer-requests-1">
                                            <h2>Request Access to Collected Data</h2>
                                            <p>We respect your privacy. Please be informed that the collected data is absolutely safe with us. To learn more about the collected data, please click the link below.  </p>
                                            <a class="btn btn-primary" data-title="Request Access to Collected Data" href="<?php echo site_url('do-not-sell-my-information-request-access') ?>">Request Access</a>
                                            
                                        </div>
                                        
                                        <div class="consumer-requests" id="consumer-requests-3">
                                            <h2>Privacy at <?php echo get_bloginfo( 'name' ); ?></h2>
                                            <p>We respect your data. For further details on our privacy policy and terms of service, please click the below links:
</p>
                                            <a style="font-weight: bold" target="_blank" href="<?php echo site_url('privacy-policy') ?>"><?php echo get_bloginfo( 'name' ); ?>'s Privacy Policy</a><br/>
                                            <a style="font-weight: bold" target="_blank" href="<?php echo site_url('terms-of-service') ?>"><?php echo get_bloginfo( 'name' ); ?>'s Terms of Service</a>
                                        </div>
                                    </div>
                            <?php endwhile;//end loop
                                comments_template('', true);
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--<script type="text/javascript">
    jQuery('.data-request-btn').click(function() {
        jQuery('.modal-form-head').html(jQuery(this).data('title'));
        jQuery('.consumer_request_type').val(jQuery(this).data('type-value'))
        jQuery('#consumer-request-modal').modal({
            backdrop: 'static',
            keyboard: false
        });
    });
    </script>-->
<?php get_footer();