<?php
$post_count = 1;
$column_count = 1;

$span = 'span3';
//$column_break = 4;
$is_404 = false;
if (is_404()) {
    $is_404 = true;
    $column_break = 4;
    $span = 'span3';

    $args = array(
        'post_type' => 'post',
        'showposts' => 6,
        'ignore_sticky_posts' => true,
    );
    query_posts($args);
}

$query = get_queried_object();
$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'post_type' => $query->name,
    'showposts' => 12,
    'paged' => $page,
    'meta_query' => array(
        array(
            'key' => 'no_pagination',
            'compare' => 'NOT EXISTS', // works!
            'value' => '' // This is ignored, but is necessary...
        )
    )
);
query_posts($args);
if (have_posts()) {

    while (have_posts()) : the_post();
        if ($column_count == 1) {
            ?>
            <div class="td-block-row">
                <?php
            }
            $post_thumbnail_url = '';

            if (get_the_post_thumbnail_url(null, 'medium_large') != false) {
                $post_thumbnail_url = get_the_post_thumbnail_url(null, 'medium_large');
            } else {
                $post_thumbnail_url = get_template_directory_uri() . '/images/no-thumb/medium_large.png';
            }
            ?>
            <div class="td-block-<?php echo esc_attr($span) ?>">


                <div class="td_module_4 td_module_wrap td-animation-stack">
                    <div class="td-module-image">
                        <div class="td-module-thumb">
                            <a href="<?php the_permalink() ?>" rel="bookmark" class="td-image-wrap" title="<?php the_title() ?>"><img class="entry-thumb td-animation-stack-type0-2" src="<?php echo $post_thumbnail_url; ?>" alt="<?php the_title() ?>"  style="width:100%" title="<?php echo esc_attr(strip_tags(the_title())) ?>" data-type="image_tag" data-img-url="<?php echo $post_thumbnail_url; ?>"></a>
                        </div>

                         <!--<div class='category-tags'>
                            <?php
                            $category_name = rtrim($query->name, 's') . '_categories';
                            echo $category_name;
                           $categories = get_the_terms($post->ID, $category_name);
                            foreach ($categories as $category) {
                                ?>
                                <a href="<?php echo get_term_link($category->term_id); ?>" class="post-category"><?php echo $category->name; ?></a>
                            <?php } ?>
                            <?php
                                $sponsored_by = get_the_terms($post->ID, 'sponsored_by');
                                foreach ($sponsored_by as $sponsored_by_single) {
                                    ?>
                                    <span class="td-post-author-name"><a href="<?php echo get_term_link($sponsored_by_single->term_id); ?>"><?php echo $sponsored_by_single->name; ?></a> <span></span> </span>
                                <?php } ?>
                        </div> -->
                    </div>


                    <h3 class="entry-title td-module-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title() ?>"><?php the_title() ?></a></h3>
                    <div class="td-module-meta-info">
                       <!-- <span class="td-post-date"><time class="entry-date updated td-module-date" datetime="<?php //echo esc_html(date(DATE_W3C, get_the_time('U'))) ?>"><?php the_time(get_option('date_format')) ?></time></span>-->
                        <br>
                        
                        <div class="td-read-more" style="margin-top: 15px;">
                            <a href="<?php the_permalink() ?>">Download</a>
                        </div>
                    </div>
                    
                </div>
                <!--            <div class="td_module_mx1 td_module_wrap td-animation-stack">
                                <div class="td-module-thumb"><a href="<?php the_permalink() ?>" rel="bookmark" class="td-image-wrap" title="<?php the_title() ?>"><img class="entry-thumb td-animation-stack-type0-2" src="<?php echo $post_thumbnail_url; ?>" alt="<?php the_title() ?>" title="<?php echo esc_attr(strip_tags(the_title())) ?>" data-type="image_tag" data-img-url="<?php echo $post_thumbnail_url; ?>"></a></div>
                                <div class="td-module-meta-info">
                                    <h3 class="entry-title td-module-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title() ?>"><?php the_title() ?></a></h3>                
                                    <div class="td-editor-date">
                                        <span class="td-author-date">
                                            <span class="td-post-date"><time class="entry-date updated td-module-date" datetime="<?php echo esc_html(date(DATE_W3C, get_the_time('U'))) ?>"><?php the_time(get_option('date_format')) ?></time></span>                    
                                        </span>
                                    </div>
                                </div>
                            </div>        -->
            </div>
            <?php if ($column_count == $column_break || $post_count == $wp_query->post_count) { ?>
            </div> <?php
            $column_count = 1;
        } else {
            $column_count++;
        }

        $post_count++;

    endwhile;

    if (!$is_404) {
        tagdiv_page_generator::get_pagination();
    }
} else {
    ?>
    <div class="no-results td-pb-padding-side">
        <h2><?php esc_html_e('No posts to display', 'newspaper') ?></h2>
    </div>
    <?php
}