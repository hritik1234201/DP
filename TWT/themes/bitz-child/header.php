<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

<meta name="facebook-domain-verification" content="im3ygrduvt2swvbfr7q53xr6vltrky" />

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="format-detection" content="telephone=no">
	<meta name="theme-color" content="<?php echo ot_get_option('accent_color', '#e74c3c'); ?>">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php esc_url(bloginfo( 'pingback_url' )); ?>">
		
	<?php wp_head(); ?>
 <?php
        $current_user = wp_get_current_user();
        $pagename = '';
        if (!$pagename && $id > 0) {
            // If a static page is set as the front page, $pagename will not be set. Retrieve it from the queried object
            $post = $wp_query->get_queried_object();
            $pagename = $post->post_name;
        }
        $page_category = '';
        $categories = get_the_category();
        $separator = ' ';
        $output = '';
        if (!empty($categories)) {
            foreach ($categories as $category) {
                $output .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" alt="' . esc_attr(sprintf(__('View all posts in %s', 'textdomain'), $category->name)) . '">' . esc_html($category->name) . '</a>' . $separator;
            }
            $page_category = trim($output, $separator);
        }

        $device_type = 'Desktop';
        $isMob = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile"));

        if ($isMob) {
            $device_type = 'Mobile';
        } else {
            $device_type = 'Desktop';
        }
        ?>
        <script title="pxsnpt" type="module">
            var c041Data={        
            cdmn:'px.anteriad.com',        
            lm:'e',
            tt:'tcs.dhj'};
            !function(a){
            a.r     = '<?php echo rand(); ?>'; //Data layer object/Macro for random number
            a.si    = '<?php echo get_current_blog_id(); ?>'; //Data layer object/Macro for SITE ID (if applicable)
            a.adv   = '';
            a.v0    = '<?php echo $current_user->email; ?>';  //Data layer object for email address (if applicable)
            a.v2    = '<?php echo get_current_blog_id(); ?>'; //DO NOT ALTER Provided by MeritB2B
            a.v3    = '<?php echo $pagename; ?>'; //Data layer object for page_name (if applicable)
            a.v4    = '<?php echo $page_category; ?>'; //Data layer object for page_type or category (if applicable)
            a.v5    = '<?php echo home_url($wp->request); ?>'; //Data layer object for URL (if applicable)
            a.v7    = '<?php echo $device_type; ?>';
            a.aqet  = 'pv';
            a.aq_m  = true;
            a.evid  = '<?php echo date('Y-m-d H:i:s'); ?>';
            }(c041Data);
            
            function _pxTagInject(p,d,w,l) {
                var s,o,k=[],t=p.tt.slice(-1),x={cdmn:1,lm:1,tt:1},y={cid:1,cls:1,dmn:1,pubid:1,evid:1,aq_m:1};
                p.dmn=(p.dmn||(w.top[l]===w[l]?''+w[l]:d.referrer).split('/')[2]).split(':')[0];
                for(o in p) {
                    if(y[o]||((t!='j'||p.aq_m)&&!x[o])) {
                        k.push(o+"="+p[o]);
                    };
                };
                s=d.createElement(t=='f'?'img':'script');
                s.id=s.title='pxscrpt';
                s.async=s.defer=!0;
                s.src='//'+p.cdmn+'/1/'+p.lm+'/'+p.tt+'?'+k.join("&");d.body.appendChild(s); 
            }
            
            _pxTagInject(c041Data,document,window,'location');
            
        </script>	
		
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-ZYSVKJMQMV"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-ZYSVKJMQMV');
</script>


<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '495411544797741');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=495411544797741&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->


<!-- Twitter universal website tag code -->
<script>
!function(e,t,n,s,u,a){e.twq||(s=e.twq=function(){s.exe?s.exe.apply(s,arguments):s.queue.push(arguments);
},s.version='1.1',s.queue=[],u=t.createElement(n),u.async=!0,u.src='//static.ads-twitter.com/uwt.js',
a=t.getElementsByTagName(n)[0],a.parentNode.insertBefore(u,a))}(window,document,'script');
// Insert Twitter Pixel ID and Standard Event data below
twq('init','o5rfj');
twq('track','PageView');
</script>
<!-- End Twitter universal website tag code -->


<script type="text/javascript">
_linkedin_partner_id = "2972554";
window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];
window._linkedin_data_partner_ids.push(_linkedin_partner_id);
</script><script type="text/javascript">
(function(){var s = document.getElementsByTagName("script")[0];
var b = document.createElement("script");
b.type = "text/javascript";b.async = true;
b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js";
s.parentNode.insertBefore(b, s);})();
</script>
<noscript>
<img height="1" width="1" style="display:none;" alt="" src="https://px.ads.linkedin.com/collect/?pid=2972554&fmt=gif" />
</noscript>


<!-- Hotjar Tracking Code for https://techwebtrends.com/ -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:2318499,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
	
<?php
        $current_user = wp_get_current_user();
        $pagename = '';
        if (!$pagename && $id > 0) {
            // If a static page is set as the front page, $pagename will not be set. Retrieve it from the queried object
            $post = $wp_query->get_queried_object();
            $pagename = $post->post_name;
        }
        $page_category = '';
        $categories = get_the_category();
        $separator = ' ';
        $output = '';
        if (!empty($categories)) {
            foreach ($categories as $category) {
                $output .= '<a href="' . esc_url(get_category_link($category->term_id)) . '" alt="' . esc_attr(sprintf(__('View all posts in %s', 'textdomain'), $category->name)) . '">' . esc_html($category->name) . '</a>' . $separator;
            }
            $page_category = trim($output, $separator);
        }

        $device_type = 'Desktop';
        $isMob = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile"));

        if ($isMob) {
            $device_type = 'Mobile';
        } else {
            $device_type = 'Desktop';
        }
        ?>
        <script title="pxsnpt" type="module">
            var c041Data={        
            cdmn:'px.anteriad.com',        
            lm:'e',
            tt:'tcs.dhj'};
            !function(a){
            a.r     = '<?php echo rand(); ?>'; //Data layer object/Macro for random number
            a.si    = '<?php echo get_current_blog_id(); ?>'; //Data layer object/Macro for SITE ID (if applicable)
            a.adv   = '';
            a.v0    = '<?php echo $current_user->email; ?>';  //Data layer object for email address (if applicable)
            a.v2    = '<?php echo get_current_blog_id(); ?>'; //DO NOT ALTER Provided by MeritB2B
            a.v3    = '<?php echo $pagename; ?>'; //Data layer object for page_name (if applicable)
            a.v4    = '<?php echo $page_category; ?>'; //Data layer object for page_type or category (if applicable)
            a.v5    = '<?php echo home_url($wp->request); ?>'; //Data layer object for URL (if applicable)
            a.v7    = '<?php echo $device_type; ?>';
            a.aqet  = 'pv';
            a.aq_m  = true;
            a.evid  = '<?php echo date('Y-m-d H:i:s'); ?>';
            }(c041Data);
            
            function _pxTagInject(p,d,w,l) {
                var o,k=[],t=p.tt.slice(-1),x={cdmn:1,lm:1,tt:1},y={cid:1,cls:1,dmn:1,pubid:1,evid:1,aq_m:1};
                p.dmn=(p.dmn||(w.top[l]===w[l]?''+w[l]:d.referrer).split('/')[2]).split(':')[0];
                for(o in p) {
                    if(y[o]||((t!='j'||p.aq_m)&&!x[o])) {
                        k.push(o+"="+p[o]);
                    };
                };
                s=d.createElement(t=='f'?'img':'script');
                s.id=s.title='pxscrpt';
                s.async=s.defer=!0;
                s.src='//'+p.cdmn+'/1/'+p.lm+'/'+p.tt+'?'+k.join("&");d.body.appendChild(s);
                _pxTagInject(c041Data,document,window,'location');
            }
        </script>
	
	
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
	
<body oncontextmenu="return false" <?php body_class( esc_attr( $body_class ) ); ?> id="site-body" itemscope itemtype="http://schema.org/WebPage">
	<div id="wrapper">
		<?php get_sidebar('top'); ?>
		
		<?php get_template_part( 'site-header' ); // Include site-header.php ?>

		<?php get_template_part( 'pre-content' ); // Include pre-content.php ?>
		
		<?php // get_template_part( 'title' ); // Include title.php ?>
		
		<div id="main" class="clearfix">
