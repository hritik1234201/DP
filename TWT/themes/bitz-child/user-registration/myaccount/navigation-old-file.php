<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/user-registration/myaccount/navigation.php.
 *
 * HOWEVER, on occasion UserRegistration will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.wpeverest.com/user-registration/template-structure/
 * @author  WPEverest
 * @package UserRegistration/Templates
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'user_registration_before_account_navigation' );
?>
<!-- <div class="my-account-nav"> -->
<nav class="user-registration-MyAccount-navigation">
	<ul>
            <?php foreach ( ur_get_account_menu_items() as $endpoint => $label ) : ?>
                <li class="<?php echo ur_get_account_menu_item_classes( $endpoint ); ?>">
                    <!--<a href="<?php echo esc_url( ur_get_account_endpoint_url( $endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>-->
                    <a href="<?php echo esc_url( site_url( '/my-account/'.$endpoint ) ); ?>"><?php echo esc_html( $label ); ?></a>
                </li>
            <?php endforeach; ?>
	</ul>
</nav>
<!-- </div> -->
<?php do_action( 'user_registration_after_account_navigation' ); ?>