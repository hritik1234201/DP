<div id="resource-posts-loop">
    <?php
    $query = get_queried_object();
    $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
//    echo '<pre>';
//print_r($page);
//echo '</pre>';
    $args = array(
        'post_type' => $query->name,
        'showposts' => 8,
        'paged' => $page,
    );
        echo '<pre>';
print_r($args);
echo '</pre>';
    query_posts($args);
    if (have_posts()) {
        while (have_posts()) : the_post();
            $post_thumbnail_url = '';

            if (get_the_post_thumbnail_url(null, 'medium_large') != false) {
                $post_thumbnail_url = get_the_post_thumbnail_url(null, 'full');
            } else {
                $post_thumbnail_url = get_template_directory_uri() . '/images/no-thumb/medium_large.png';
            }
            ?>
            <div class="td_module_flex td_module_flex_1 td_module_wrap td-animation-stack">
                <div class="td-module-container td-category-pos-above">
                    <div class="td-image-container">
            <!--                                                            <div class="td-module-thumb"><a href="<?php the_permalink() ?>" rel="bookmark" class="td-image-wrap " title="<?php the_title_attribute() ?>"><span class="entry-thumb td-thumb-css" data-type="css_image" data-img-url="<?php echo esc_url($post_thumbnail_url) ?>" style="background-image: url(<?php // echo esc_url($post_thumbnail_url)        ?>)"></span></a></div>-->
                        <div class="td-module-thumb">
                            <a href="<?php the_permalink() ?>" rel="bookmark" class="td-image-wrap " title="<?php the_title_attribute() ?>">
                                <img src="<?php echo esc_url($post_thumbnail_url) ?>)" class="resources-img-wrap" />
                            </a></div>
                    </div>

                    <div class="td-module-meta-info">
                        <?php
                                $sponsored_by = get_the_terms($post->ID, 'sponsored_by');
                                foreach ($sponsored_by as $sponsored_by_single) {
                                    ?>
                                    <span class="td-post-author-name"><a href="<?php echo get_term_link($sponsored_by_single->term_id); ?>"><?php echo $sponsored_by_single->name; ?></a> <span></span> </span>
                                <?php } ?> 
                        <?php
                        $categories = get_the_terms($post->ID, 'resource_types');
                        foreach ($categories as $category) {
                            ?>
                            <a href="<?php echo get_term_link($category->term_id); ?>" class="resource-category  td-post-category" style="text-transform: initial !important;"><?php echo $category->name; ?></a>
                        <?php } ?> 

                        <h3 class="entry-title td-module-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute() ?>"><?php the_title() ?></a></h3>
                        <a style="border-color:#fff;"  class="read-more" href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php echo "Download Now";//__herald('read_more'); ?></a>
                        <div class="td-excerpt"><?php the_excerpt(); ?></div>
                        <div class="td-editor-date">

                            <span class="td-author-date">
            <!--                                                                    <span class="td-post-author-name"><a href="<?php // echo esc_url(get_author_posts_url(get_the_author_meta('ID')))            ?>"><?php // the_author()            ?></a> <span>-</span> </span>-->
                                
                                <!--<span class="td-post-date"><time class="entry-date updated td-module-date" datetime="<?php echo esc_html(date(DATE_W3C, get_the_time('U'))) ?>"><?php the_time(get_option('date_format')) ?></time></span>-->
                                <!--<span class="td-module-comments"><a href="https://staging.thehrempire.com/resources/5-key-hr-trends-to-drive-digital-transformation/#respond">0</a></span>-->
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        endwhile;
        ?>
    <div style="display: none;">
        <?php tagdiv_page_generator::get_pagination(); ?>
    </div>
    <?php } ?>
</div>



<!--    <div class="td-load-more-wrap">
        <a href="#" class="td_ajax_load_more td_ajax_load_more_js" id="next-page-resource-posts-loop" data-td_block_id="resource-posts-loop">
        Load more<i class="td-icon-font td-icon-menu-down"></i></a>
    </div>-->