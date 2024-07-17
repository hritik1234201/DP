<?php get_header(); ?>

<style>
.body-container-resource-inner{
	    margin-top: 30px;
    margin-left: -20px;
    margin-right: -20px;
}

.body-container-resource-inner .wpb_column12.vc_column_container.vc_col-lg-4.vc_col-xs-12.vc_col-md-4.vc_col-sm-4:nth-child(3n+1) {
    clear: both;
}

time.entry-date.updated.td-module-date {
    /*text-transform: capitalize !important;*/
    color: #052f85 !important;
    font-style: italic !important;
    font-size: 11px;
}

.custom-views{
	color: #052f85 !important;
    font-style: italic !important;
    font-size: 11px;
}

#main{
	padding: 30px 30px !important;
}

</style>
	
<h2><?php echo $current_category = single_cat_title("", false); ?></h2>

<div class="body-container-resource-inner">
	<?php
	if (have_posts()) {
		
		$i = 0;

		while (have_posts()) : the_post();
		
			$i++;
			
			$post_thumbnail_url = '';

			if (get_the_post_thumbnail_url(null, 'medium_large') != false) {
				$post_thumbnail_url = get_the_post_thumbnail_url(null, 'medium_large');
			} else {
				$post_thumbnail_url = get_template_directory_uri() . '/images/no-thumb/medium_large.png';
			}
			?>
			<div class="wpb_column12 vc_column_container vc_col-lg-3 vc_col-xs-12 vc_col-md-3 vc_col-sm-6" style="padding-left: 20px;padding-right: 20px;padding-bottom: 35px;margin-bottom: 15px;">
				<div class="td-module-container td-category-pos-above">
					<div class="td-image-container123">
					
						<div class="td-module-thumb"><a href="<?php the_permalink() ?>" rel="bookmark" class="td-image-wrap " title="<?php the_title_attribute() ?>"><img src="<?php echo esc_url($post_thumbnail_url) ?>)" alt="<?php the_title_attribute() ?>" class="img-responsive" /></a></div>
						
					</div>

					<div class="td-module-meta-info123" style="padding: 5px 5px;"><!-- -->
						<?php
						$categories = get_the_terms($post->ID, 'resource_types');
						foreach ($categories as $category) {
							?>
							<a href="<?php echo get_term_link($category->term_id); ?>" class="resource-category  td-post-category"><?php echo $category->name; ?></a>
						<?php } ?> 

						<h3 style="margin-bottom: 0px !important;" class="entry-title td-module-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute() ?>"><?php the_title() ?></a></h3>
						<div class="td-editor-date">

							<span class="td-author-date">
							   
								<span class="td-post-date"><time class="entry-date updated td-module-date" datetime="<?php echo esc_html(date(DATE_W3C, get_the_time('U'))) ?>"><?php the_time(get_option('date_format')) ?></time></span>
								<span>|</span>
								<span class="custom-views"><i class="post-icon icon-views"></i> <?php echo get_PostViews(get_the_ID()); ?></span>
								
							</span>
						</div>                                                            
					</div>
				</div>
			</div>
			<?php
		if( $i % 2 == 0 ){
			echo '<div class="clearfix vc_hidden-lg vc_hidden-md"></div>';
		}
		if( $i % 4 == 0 ){
			echo '<div class="clearfix vc_hidden-sm"></div>';
		}
		
		endwhile;
		
	}
	?>

</div>               
<?php
get_footer();
