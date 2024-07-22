<?php
/* Template Name: Landing Page Template - With Logo Head */
get_header('landingpage'); ?>

    <div class="td-main-content-wrap td-container-wrap">
        <!--<div class="td-container">-->
<!--            <div class="td-crumb-container">
                <?php // echo tagdiv_page_generator::get_breadcrumbs(array(
//                    'template' => 'page',
//                    'page_title' => get_the_title(),
//                )); ?>
            </div>-->

            <div class="td-pb-row">
                <div class="td-pb-span12 td-main-content">
                    <div class="td-ss-main-content">
                        <?php
                            if (have_posts()) {
                                while ( have_posts() ) : the_post();
                                    ?>
<!--                                    <div class="td-page-header">
                                        <h1 class="entry-title td-page-title">
                                            <span><?php // the_title() ?></span>
                                        </h1>
                                    </div>-->
                                    <div class="td-page-content tagdiv-type" style="padding-bottom: 0;">
                                        <div class="" style="margin: 20px auto;margin-bottom: 0; max-width: 1170px;">
            <a class="" href="https://techversions.com/" data-wpel-link="internal">
                <img src="https://techversions.com/wp-content/uploads/2020/02/Image20200212125837.png" alt="TechVersions" title="TechVersions">
            </a>
                                        </div>
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
        <!--</div>-->
    </div>

<?php get_footer('survey');