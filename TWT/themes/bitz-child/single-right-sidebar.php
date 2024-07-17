<?php
/*
Single Post Template: Right Sidebar
*/
?>
<?php get_header(); ?>
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
           Sales News Source: <a href="<?php echo (get_post_meta($post->ID, '_source_url', true) != '') ? get_post_meta($post->ID, '_source_url', true) : home_url(); ?>" target="_blank"><?php echo (get_post_meta($post->ID, '_source_name', true) != '') ? get_post_meta($post->ID, '_source_name', true) : 'source'; ?></a></div>
        <?php } 
        ?>
		
		<h3 class="content-widget-title Related-post">Related Posts</h3>
		
		<?php
		echo do_shortcode('[mnky_related_posts num="3"]');
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