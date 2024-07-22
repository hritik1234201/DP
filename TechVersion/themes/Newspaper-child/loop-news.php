<?php
$post_count = 1;
$column_count = 1;

$span = 'span12';
$column_break = 0;
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
            $post_time = get_the_time('Y-m-d H:i:s', $post->ID);
            ?>
            <div class="td-block-<?php echo esc_attr($span) ?>">

                <div class="td_module_6 td_module_wrap td-animation-stack">

                    <div class="td-module-thumb"><a href="<?php the_permalink() ?>" rel="bookmark" class="td-image-wrap" title="<?php the_title() ?>"><img class="entry-thumb td-animation-stack-type0-2" src="<?php echo $post_thumbnail_url; ?>" alt="<?php the_title() ?>" title="<?php echo esc_attr(strip_tags(the_title())) ?>" data-type="image_tag" data-img-url="<?php echo $post_thumbnail_url; ?>" width="100" height="70"></a></div>
                    <div class="item-details">
                        <h3 class="entry-title td-module-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title() ?>"><?php the_title() ?></a></h3>
                        <div class="td-module-meta-info">
                            <span class="td-post-date"><time class="entry-date updated td-module-date" datetime="<?php echo esc_html(date(DATE_W3C, get_the_time('U'))) ?>"><?php
                                    $time_elapsed = time_elapsed_string($post_time);
                                    // if ($time_elapsed === '') {
                                        echo the_time(get_option('date_format'));
                                    // } else {
                                        //echo '<span class="timelapse"><b>' . $time_elapsed . '</b></span>';
                                    // }  // the_time(get_option('date_format')) 
                                    ?></time>
                            </span>
                            <span class="td-post-views" style="">
                                <i class="fa fa-eye" aria-hidden="true"></i> 
                                <?php echo getPostViews($post->ID); ?>
                            </span>
                            <!--<span class="td-post-date td-post-source" style="margin-top: 5px;">Source: <a href="<?php // echo (get_post_meta($post->ID, '_source_url', true) != '') ? get_post_meta($post->ID, '_source_url', true) : 'https://www.google.com/';  ?>" target="_blank"><?php // echo (get_post_meta($post->ID, '_source_name', true) != '') ? get_post_meta($post->ID, '_source_name', true) : 'source';  ?></a></span>-->   
                        </div>
                    </div>

                </div>
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