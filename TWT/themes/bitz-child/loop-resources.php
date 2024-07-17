<?php

	if(function_exists('show_ti_posts_fn')){
		
		do_shortcode('[show_ti_posts type="resources" ppp="9" show-tax="yes" tax-name="resource_types"]');
		
	}else{
		
		$default_posts_per_page = get_option( 'posts_per_page' );

		$args = array(
			'post_type' => 'resources',
			'posts_per_page' => $default_posts_per_page
		);

		$loop = new WP_Query($args);
											
		if ($loop->have_posts()) {
			
			?>
			<div class="post_loop_">
			
			<?php
					
			while ($loop->have_posts()) : $loop->the_post();
			
				$post_thumbnail_url = '';

				if (get_the_post_thumbnail_url(null, 'medium_large') != false) {
					
					$post_thumbnail_url = get_the_post_thumbnail_url(null, 'medium_large');
					
				} else {
					
					$post_thumbnail_url = get_template_directory_uri() . '/images/no-thumb/medium_large.png';
					
				}
				
				?>
				
				<div class="wpb_column12 vc_column_container latestmoreBox latestblogBox vc_col-lg-3 vc_col-xs-12 vc_col-md-3 vc_col-sm-3" style="padding-left: 20px;padding-right: 20px;padding-bottom: 35px;margin-bottom: 15px;">
				
					<div class="td-module-container td-category-pos-above">
					
						<div class="td-image-container123">
							<div class="td-module-thumb"><a href="<?php the_permalink() ?>" rel="bookmark" class="td-image-wrap " title="<?php the_title_attribute() ?>"><img src="<?php echo esc_url($post_thumbnail_url) ?>)" alt="<?php the_title_attribute() ?>" class="img-responsive"  /></a></div>
						</div>

						<div class="td-module-meta-info123" style="padding: 20px 20px;">
							<?php
							$categories = get_the_terms($post->ID, 'resource_types');
							if($categories){
								foreach ($categories as $category) {
								?>
								<a href="<?php echo get_term_link($category->term_id); ?>" class="resource-category  td-post-category"><?php echo $category->name; ?></a>
							<?php
								}
							
							}
							?> 

							<h3 style="margin-bottom: 0px !important;" class="entry-title td-module-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute() ?>"><?php the_title() ?></a></h3>
							<div class="td-editor-date">

								<span class="td-author-date">
								
									<span class="td-post-date"><time class="entry-date updated td-module-date" datetime="<?php echo esc_html(date(DATE_W3C, get_the_time('U'))) ?>"><?php the_time(get_option('date_format')) ?></time></span>
																		
								</span>

							</div>

						</div>

					</div>

				</div>

				<?php
					
			
				
			endwhile; 
				
				?>
					
			</div>		
			
		<?php 
		
		}
		
		wp_reset_postdata();
	
	}
	
	?>
			