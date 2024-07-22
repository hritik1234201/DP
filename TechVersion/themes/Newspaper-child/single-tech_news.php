<?php
/*
 * Template Name: News -  No Sidebar Template
 * Template Post Type: post, tech_news
 */
get_header();
global $content_width;

$content_width = 1068;
?>

<style>
.page-template-page-blogs .td-post-author-name, .post .td-post-author-name {
    display: none;
}
</style>

<div class="td-main-content-wrap td-container-wrap">
    <div class="td-container">
    <div class="entry-crumbs td-crumb-container breadcrum"><span><a title="" class="tdb-entry-crumb " href="#">Home</a></span> <i class="td-icon-right td-bread-sep"></i> <span>News</span> <i class="td-icon-right td-bread-sep "></i> <span class="tdb-bred-no-url-last"><?php echo the_title() ?></span></div>

        <!--<div class="td-crumb-container">
            <?php
            //echo tagdiv_page_generator::get_breadcrumbs(array(
               // 'template' => 'single',
              //  'title' => get_the_title(),
           // ));
           // ?>
        </div>-->

        <div class="td-pb-row allnews">
            <!--                <div class="td-pb-span12 td-main-content">
                                <div class="td-ss-main-content">
            <?php
//            get_template_part('loop-single');
//            comments_template('', true);
            ?>
                                </div>
                            </div>-->
            <div class="td-pb-span8 td-main-content">
                <div class="td-ss-main-content">
                    <?php
                    get_template_part('loop-single-news');
                    ?>
                </div>
            </div>

            <div class="td-pb-span4 td-main-sidebar">
                <div class="td-ss-main-sidebar">
                    <?php dynamic_sidebar('single_news_sidebar') ?>
                    <?php // dynamic_sidebar( 'new_sidebar' )  ?>
                    <?php // dynamic_sidebar( 'td-default' )  ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
