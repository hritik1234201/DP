<?php get_header();?>
<!-- 
<link href="https://thesalesmark.com/wp-content/themes/bitz-child/template/css/load-more-button.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://thesalesmark.com/wp-content/themes/bitz-child/template/js/load-more-button.js"></script>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
-->
<script>
/* 
$(function() {
    $('.popup-youtube, .popup-vimeo').magnificPopup({
        //disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: true,
        fixedContentPos: true
    });
}); */
</script>
<style>
.centered {
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
}
.container123 {
	position: relative;
	color: white;
}
.container-video {
	position: relative;
	width: 100%;
	overflow: hidden;
	padding-top: 56.25%; /* 16:9 Aspect Ratio */
}
.responsive-iframe {
	position: absolute;
	top: 0;
	left: 0;
	bottom: 0;
	right: 0;
	width: 100%;
	height: 100%;
	border: none;
}
.nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover{
	background-color: transparent !important;
	color:#1f1f1f !important;
}
li.heading-category.active {
    border-top: 1px solid #c53f45 !important;
    top: -5px !important;
}
li.heading-category{
color:#999 !important;
}
.td-image-container123 .td-module-thumb img{
	border-radius:10px;
}
.heading_wrapper_video {
	padding:20px 0px 0px 0px !important
}
h3.entry-title.td-module-title.new-title{
	font-size:18px;
	margin-bottom: 1px !important;
}
span.td-author-date {
    font-size: 12px !important;
}
</style>

<!-- FEATURED INSIGHTS -->

<!-- <div class="heading_wrapper_video">

<h1 style="margin-bottom:10px;" class="tdb-title-text">Latest Videos</h1>

</div> -->

<div class="body-container-video">

	<div class="vc_col-lg-12 vc_col-xs-12 vc_col-md-12 vc_col-sm-12">
										
	<?php

		$query = get_queried_object();
		$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
			'post_type' => $query->name,
			'posts_per_page' => -1,
			'paged' => $page,
		);
		query_posts($args);
		if (have_posts()) {
			while (have_posts()) : the_post();
		
				$categories = get_the_terms($post->ID, 'videos_types');
				
				foreach ($categories as $category) {
					
					$cat = $category->term_id;
					
					//print $cat;

					if($cat == "355"){ ?>
															
						<?php

						$post_thumbnail_url = '';

						if (get_the_post_thumbnail_url(null, 'medium_large') != false) {
							$post_thumbnail_url = get_the_post_thumbnail_url(null, 'medium_large');
						} else {
							$post_thumbnail_url = get_template_directory_uri() . '/images/no-thumb/medium_large.png';
						}

						$custom = get_post_custom();
						$test = array($custom);

						$cats =  get_post_meta(get_the_ID(), 'Custom_Tag', TRUE);

						?>

						<div class="wpb_column12 vc_column_container latestmoreBox latestblogBox vc_col-lg-4 vc_col-xs-12 vc_col-md-4 vc_col-sm-4" style="padding-left: 20px;padding-right: 20px;">

							<div class="td-image-container123 container123">
								  
								<div class="td-module-thumb img-thumb">
									<a href="<?php echo get_the_permalink(get_the_ID()); ?>">
										<img src="<?php echo esc_url($post_thumbnail_url) ?>" alt="<?php the_title_attribute() ?>" class="img-responsive"  />
									</a>
								</div>
								
								<a class="popup-youtube" href="<?php echo get_the_permalink(get_the_ID()); ?>"><div class="centered"><i class="fa fa-play-circle-o" style="font-size:48px;color:#fff"></i></div></a>
								
							</div>
															
							<div class="td-module-meta-info1234" style="padding: 15px 15px;min-height:100px;">
								<?php
								$categories = get_the_terms($post->ID, 'videos_types');
								foreach ($categories as $category) {
								?>
								<div class="resource-category123  td-post-category"><?php //echo $category->name; ?></div> 
								<?php } ?> 

								<h3 class="entry-title td-module-title new-title">

									<a class="popup-youtube123" href="<?php echo get_the_permalink(get_the_ID()); ?>"><?php //the_title_attribute() ?><?php the_title() ?></a><br>

								</h3>
								 

                                                                <span class="td-author-date">
                                                                                                                                           
                                                                    <span class="td-post-date"><time class="entry-date updated td-module-date" datetime="<?php echo esc_html(date(DATE_W3C, get_the_time('U'))) ?>"><?php the_time(get_option('date_format')) ?></time></span>
                                                                   
                                                                </span>
                                                           
							</div>
							 
						</div>

						<?php
					}
				}
			endwhile;
		}
	?>
																	
	<!--	<div id="latestloadMore" style="">
	<a href="#">Load More</a>
	</div>		 -->
	</div> 
										
<!--	<div class="vc_col-lg-4 vc_col-xs-12 vc_col-md-4 vc_col-sm-4">

		<div class="widget" style="margin:0px">
			<h3 class="widget-title">What’s Trending</h3>
		</div>
		
		<div style="margin-bottom:50px;" class="sticky-container">
			<?php //echo do_shortcode('[mnky_posts layout="6" rating_hide="off" author_hide="off" comments_hide="off" date_hide="off" posts_per_page="5" orderby="meta_value_num" image_disabled=""]');  ?>
		</div>

	</div> -->
									
</div>
											
<?php
get_footer();