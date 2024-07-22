<?php 
/*
 * Template Name: SDM Downloads - Template Nmae
 */
get_header(); ?>
<style type="text/css">
/*    @media only screen and (max-width: 600px) {
        .td-ss-main-content {
            width: 100%
        }
    }
    @media only screen and (min-width: 601px) {
        .td-ss-main-content {
            width: 60%
        }
    }*/
</style>
    <div class="td-main-content-wrap td-container-wrap">
        <div class="td-container">
            <div class="td-crumb-container">
                <?php // echo tagdiv_page_generator::get_breadcrumbs(array(
//                    'template' => 'page',
//                    'page_title' => get_the_title(),
//                )); ?>
            </div>

            <div class="td-pb-row" style="text-align: center;display: block;min-height: 1px;float: none !important;padding-right: 24px;padding-left: 24px;position: relative;margin: 0 auto;">
                <div class="td-pb-span12 td-main-content">
                    <div class="td-ss-main-content" style="margin: 0 auto;text-align: left">
                        <?php
                            if (have_posts()) {
                                while ( have_posts() ) : the_post();
                                    ?>
                                    <div class="td-page-header">
                                        <h1 class="entry-title td-page-title">
                                            <span><?php the_title() ?></span>
                                        </h1>
                                    </div>
                                    <div class="td-page-content tagdiv-type">
                                        <?php the_content(); ?>
                                    </div>
                            <?php endwhile;//end loop
//                                comments_template('', true);
                            }
                        ?>
                    </div>
                </div>

<!--                <div class="td-pb-span4 td-main-sidebar">
                    <div class="td-ss-main-sidebar">
                        <?php // dynamic_sidebar( 'td-default' ) ?>
                    </div>
                </div>-->
            </div>
        </div>
    </div>

<?php get_footer(); ?>