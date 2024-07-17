<?php
/* Template Name: Landing Page - 4 Template
 * Template Post Type: post, resources
 *  */
get_header();
global $content_width;

$content_width = 1068;
?>

<div class="td-main-content-wrap td-container-wrap landing-page">
    <!--<div class="td-container">-->
        <div class="td-crumb-container">
            <?php
            echo tagdiv_page_generator::get_breadcrumbs(array(
                'template' => 'single',
                'title' => get_the_title(),
            ));
            ?>
        </div>

        <div class="td-pb-row">
            <div class="td-pb-span12 td-main-content">
                <div class="td-ss-main-content landing-page-4">
                    <div class="row2" style="">
                        <div class="row2-col1 column">
                            <h1 class="page-h1-head"><?php echo get_the_title(); ?></h1>
                            <?php the_content(); ?>
                            <div class="download-form" style="display: none;"><?php echo do_shortcode('[Form id="8"]'); ?></div>
                            <div class="mobile-download-form" style="display: none;"><?php echo do_shortcode('[Form id="8"]'); ?></div>
                            <p><button class="download-btn">Access the White Paper</button></p>
                        </div>
                        <div class="row2-col2 column"><img src="<?php echo esc_url(get_the_post_thumbnail_url(null, 'medium_large')) ?>" /></div>
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