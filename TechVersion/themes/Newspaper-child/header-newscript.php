<?php
//die();
//do_action( 'tdc_header' );
//if ( has_action( 'tdc_header' ) ) {
    //return;
//}
?>
<!doctype html >
<html <?php language_attributes(); ?>>
    <head>
      
        <meta charset="<?php bloginfo('charset'); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <?php wp_head(); ?>

        <script src="https://js.adsrvr.org/up_loader.1.1.0.js" type="text/javascript"></script>
        <script type="text/javascript">
            ttd_dom_ready( function() {
                if (typeof TTDUniversalPixelApi === 'function') {
                    var universalPixelApi = new TTDUniversalPixelApi();
                    universalPixelApi.init("veme4uw", ["g93q0oy"], "https://insight.adsrvr.org/track/up");
                }
            });
        </script>

    </head>

  