<?php
/*
Single Post Template: Right Sidebar
*/
?>
<?php get_header(); ?>

<style>
.pre-content{
	display:none;
}
.single-videos .post-preview{
	display:none;
}
.meta-author-image{
    display:none;
}
a.meta-author.url{
    display:none;
}
.centered {
    position: absolute;
    top: 0%;
    left: 50%;
    transform: translate(-50%, 70%);
}
.mrp-3 .related-post-container{position: relative;}
@media only screen and (max-width: 767px){iframe{height:auto}}
</style>

<?php if ( ! function_exists( 'mnky_ajax_enqueue_scripts' )) { mnky_setPostViews( get_the_ID() );} ?>
<?php get_sidebar('before-post'); ?>

		<div id="container" class="clearfix">

				<div id="content" class="float-left">
				
					<?php while ( have_posts() ) : the_post(); ?>
					
					

						<?php get_template_part( 'content', 'single' ); ?>
						
						 <?php
						 //print_r ( get_post_meta($post->ID));
						 
        //if(get_post_type( get_the_ID()) == 'sales-news') {
			if(get_post_meta($post->ID, '_source_name', true)){
            ?>
        <div class="td-post-date td-post-source" style="margin-top: 5px;">
           News Source: <a href="<?php echo (get_post_meta($post->ID, '_source_url', true) != '') ? get_post_meta($post->ID, '_source_url', true) : home_url(); ?>" target="_blank"><?php echo (get_post_meta($post->ID, '_source_name', true) != '') ? get_post_meta($post->ID, '_source_name', true) : 'source'; ?></a></div>
        <?php } 
        ?>
		
		 <h3 class="content-widget-title Related-post">Related Videos</h3> 
		 
		 <?php $related = get_posts(array('post_type' => 'videos', 'numberposts' => 3, 'exclude' => array($post->ID))); ?>
                           
						   
						   <ul class="mnky-related-posts mrp-3 clearfix">
						   
                            <?php
                            if ($related) {
                                foreach ($related as $single_post) {
                                    ?>
                                    
                                       
                                          <li class="related-post-container">
                                                    <a href="<?php echo get_permalink($single_post->ID); ?>" rel="bookmark" class="td-image-wrap" title="<?php echo $single_post->post_title; ?>" data-wpel-link="internal">
                                                        <img class="img-responsive entry-thumb td-animation-stack-type0-2" 
                                                             src="<?php echo get_the_post_thumbnail_url($single_post->ID) ?>" 
                                                             alt="<?php echo $single_post->post_title; ?>" 
                                                             title="<?php echo $single_post->post_title; ?>" 
                                                             data-type="image_tag" 
                                                             data-img-url="<?php echo get_the_post_thumbnail_url($single_post->ID) ?>" 
                                                            />
                                                            <div class="centered"><i class="fa fa-play-circle-o" style="font-size:48px;color:#fff"></i></div>
                                                    </a>
                                                
                                         
                                                <h6>
                                                    <a href="<?php echo get_permalink($single_post->ID); ?>" rel="bookmark" 
                                                       title="<?php echo $single_post->post_title; ?>" 
                                                       data-wpel-link="internal"><?php echo $single_post->post_title; ?></a>
                                                </h6> 
                                                <!--<p class="entry-title td-module-title" style="text-align: left;"></p>-->
                                           </li>
                                       
                                    
                                    <?php
                                }
                            }
                            ?>
							
							</ul>
		
		<?php
		//echo do_shortcode('[mnky_related_posts num="3"]');
		?>
						
						<?php
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						} ?>
						
					<?php endwhile; ?>
						
				</div><!-- #content -->
				
				<div itemscope itemtype="http://schema.org/WPSideBar" id="sidebar" class="float-right">
					<?php get_sidebar('blog'); ?>
				</div>			

		</div><!-- #container -->

<?php get_footer(); ?>