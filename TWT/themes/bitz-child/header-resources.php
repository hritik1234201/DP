<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="format-detection" content="telephone=no">
	<meta name="theme-color" content="<?php echo ot_get_option('accent_color', '#e74c3c'); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php esc_url(bloginfo( 'pingback_url' )); ?>">
		
	<?php wp_head(); ?>
</head>
	
<?php 
	$body_class = '';

	if( ot_get_option('sticky_sidebar') != 'off' ) {
		$body_class = 'sticky-sidebar';
	}
	
	if ( class_exists('Mobile_Detect') ){
		$detect = new Mobile_Detect;
		if ( $detect->isMobile() ) {
			$body_class = '';
		}
	}
?>
	
<body <?php body_class( esc_attr( $body_class ) ); ?> id="site-body" itemscope itemtype="http://schema.org/WebPage">
	<div id="wrapper">
		<?php get_sidebar('top'); ?>
		
		<?php get_template_part( 'site-header' ); // Include site-header.php ?>

		<?php get_template_part( 'pre-content' ); // Include pre-content.php ?>
		
		<?php // get_template_part( 'title' ); // Include title.php ?>
		
		
		<!--<div class="pageBanner" style="background-image:url('<?php echo esc_attr( get_option('resource_page_banner') ); ?>')">
		
			
			<h2><?php echo esc_attr( get_option('resource_page_description') ); ?></h2>
			
		</div>-->
		
		<div id="main" class="clearfix">
		<div class="heading_wrapper">
		<h2><?php echo esc_attr( get_option('resource_page_title') ); ?></h2> 
		<div class="heading-line" style="background-color:#e2e2e2"><span style="background-color:#009eed"></span></div>	
		</div>
		

