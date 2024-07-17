<?php get_header();

function custom_archive_posts_per_page($query) {
    if (is_archive() && $query->is_main_query()) {
        $query->set('posts_per_page', 4); // Change this number to your desired posts per page
    }
}
add_action('pre_get_posts', 'custom_archive_posts_per_page');
 ?>


<style>
	#content.float-left {
    padding-right: 0px;
}

	.archive-layout.layout-two-column.post-main {
    width: 47.2%;
    float: left;
    margin-right: 20px;
    margin-bottom: 20px;
}
.archive-layout.layout-two-column.post-main {
    width: 30%;
    float: left;
    margin-right: 20px;
    margin-bottom: 20px;
}
@media only screen and (max-width: 1024px){
	.archive-layout.layout-two-column.post-main{width: 46.9%;}
}
@media only screen and (max-width:768px){
	.archive-layout.layout-two-column.post-main {
	width: 100%  !important;
	}
	#main {
    padding: 30px 30px 40px 30px;
}
#sidebar.float-right{    margin: 30px 0px 0px;}
}

	</style>
	<?php
	$author_id = get_the_author_meta('ID');

	// Get the author's bio
	$author_bio = get_user_meta($author_id, 'description', true);

	 if (is_author()) { ?>
		<div class="heading_wrapper">
    <h2>Post By: <?php the_author(); ?></h2>
	<div class="heading-line" style="background-color:#e2e2e2"><span style="background-color:#009eed"></span></div>
	<p style="margin-bottom: 0px;margin-top: 15px;"><?php the_author_meta( 'description' ); ?></p>
	</div>
<?php
/*if ($author_bio) {
    echo '<div class="author-bio">' . esc_html($author_bio) . '</div>';
}*/
 } else { ?>
    <div class="heading_wrapper">
        <h2><?php echo single_term_title(); ?></h2>
        <div class="heading-line" style="background-color:#e2e2e2"><span style="background-color:#009eed"></span></div>
    </div>
<?php } ?>

<span style="border-color:#222222;" class="vc_sep_line"></span>
<div id="content">
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
			<div class="archive-layout  archive-style-7 layout-two-column post-main " >
				<div class="td-module-container td-category-pos-above">
					<div class="td-image-container123">
					<div class="post-content-bg" style="background-image:url('<?php echo esc_url($post_thumbnail_url) ?>');">
					<a href="<?php the_permalink() ?>" rel="bookmark" class="archive-style-7-bg-url " title="<?php the_title_attribute() ?>">
					<a href="<?php the_permalink() ?>" rel="bookmark" class="format-icon" title="<?php the_title_attribute() ?>">
					<div class="post-content-wrapper">
					<header class="post-entry-header">
					<h2 itemprop="headline" class="entry-title">
					<a href="<?php the_permalink() ?>" rel="bookmark"  title="<?php the_title_attribute() ?>"><?php the_title_attribute() ?></a>
					</h2>
		           </header>
				   <?php 
$category = get_the_category();
if ( ! empty( $category ) ) {
    // Access the first category in the array
    $cat = $category[0]; 
    echo '<span class="entry-category" style="font-size:10px"><a href="' . esc_url( get_category_link( $cat->term_id ) ) . '">' . esc_html( $cat->name ) . '</a></span>';
}
?>
				  
				   <div class="entry-meta-blog">
				   <?php $author_id = get_the_author_meta('ID'); ?>
					<a class="meta-author url meta-author-divider" href="<?php echo esc_url(get_author_posts_url($author_id)); ?>" title="View all posts by <?php the_author(); ?>" rel="author">
						<span itemprop="author" itemscope="" ><span itemprop="name"><?php the_author(); ?></span></a>
						<span class="meta-date"><time class="published" datetime="2023-06-13T00:53:11-04:00" itemprop="datePublished"><?php the_time(get_option('date_format')) ?></time></span>
						</div>
					</div>
					</div>
						
					</div>

					
				</div>
			</div>
			<?php
		
		
		endwhile;
		?>
		<div class="pagination">
    <?php
	 global $wp_query;
    
	 $big = 999999999;
   
        echo paginate_links(array(
			'base'    => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
			'format'  => '?paged=%#%',
			'current' => max(1, get_query_var('paged')),
			'total'   => $wp_query->max_num_pages,
			'prev_text' => __('&laquo; Previous', 'bitz'),
			'next_text' => __('Next &raquo;', 'bitz'),
    ));
    ?>
</div>
	<?php }
	
	?>

</div>    
		
</aside>
</div>

<?php
get_footer();
