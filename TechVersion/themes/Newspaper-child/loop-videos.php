<?php
/**
 * The single post loop Default template
 **/


if (have_posts()) {
    the_post(); ?>
    <article class="<?php echo join(' ', get_post_class());?>" data-post-url="<?php echo get_the_permalink(); ?>" data-post-edit-url="<?php echo home_url(); ?>/wp-admin/post.php?post=<?php echo get_the_ID(); ?>&amp;action=edit" data-post-title="<?php the_title() ?>">
        <div class="td-post-header">
            <ul class="td-category">
                <?php
                $categories = get_the_category();
                if( !empty( $categories ) ) {
                    foreach($categories as $category) {
                        $cat_link = get_category_link($category->cat_ID);
                        $cat_name = $category->name; ?>
                        <li class="entry-category"><a href="<?php echo esc_url($cat_link) ?>"><?php echo esc_html($cat_name) ?></a></li>
                    <?php }
                } ?>
            </ul>

            <header class="td-post-title">
                <!-- title -->
                <h3 class="entry-title td-module-title" title="<?php the_title_attribute() ?>">
                    <!--<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute() ?>">-->
                        <?php the_title() ?>
                    <!--</a>-->
                </h3>

                <div class="td-module-meta-info">
                    <!-- author -->
<!--                    <div class="td-post-author-name">
                        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta( 'ID' ))) ?>"><?php the_author() ?></a>
                        <div class="td-author-line"> - </div>
                    </div>-->

                    <!-- date -->
                    <span class="td-post-date">
                        <time class="entry-date updated td-module-date" datetime="<?php echo esc_html(date(DATE_W3C, get_the_time('U'))) ?>" ><?php the_time(get_option('date_format')) ?></time>
                    </span>
                    <span class="td-post-views" style="">
                                <i class="fa fa-eye" aria-hidden="true"></i> 
                                <?php echo getPostViews($post->ID); ?>
                            </span>
                    <!-- comments -->
<!--                    <div class="td-post-comments">
                        <a href="<?php comments_link() ?>">
                            <i class="td-icon-comments"></i>
                            <?php comments_number('0','1','%') ?>
                        </a>
                    </div>-->
                </div>
            </header>

            <div class="td-post-content tagdiv-type">
                <!-- image -->
               
                <div class="news-content">
                <?php the_content() ?>
                </div>
               
            </div>


        </div>
        
    </article>
	
	<hr>
	
<!--	<style>
	.tdc-row{
		width: 1200px !important;
	} 
	</style> -->
		
<?php 
	echo do_shortcode('[tdc_zone type="tdc_content"][vc_row full_width="stretch_row_1400 td-stretch-content"][vc_column][td_block_3 modules_on_row="" limit="6" hide_audio="yes" image_size="td_485x360" image_height="100" image_floated="float_left" image_width="20" meta_margin="10px" meta_padding="10px" installed_post_types="videos" sort="oldest_posts" ajax_pagination="load_more" custom_title="In Other Videos" block_template_id="td_block_template_5" show_author="none" show_date="none" show_excerpt="none" show_review="none" show_com="none" m2_el="0" m1f_title_font_size="19px" m1f_title_font_line_height="1.4" m1f_meta_font_size="11px" tdc_css="eyJhbGwiOnsicGFkZGluZy10b3AiOiIyMHB4IiwiZGlzcGxheSI6IiJ9fQ==" el_class="other_video" m1f_title_font_weight="eyJhbGwiOiI2MDAiLCJwaG9uZSI6IjUwMCJ9"][/vc_column][/vc_row][/tdc_zone]');
	?>
<?php 

}
        
    ?>