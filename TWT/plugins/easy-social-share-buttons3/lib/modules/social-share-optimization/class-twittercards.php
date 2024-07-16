<?php
/**
 * @package EasySocialShareButtons\SocialShareOptimization
 * @author appscreo
 * @since 4.2
 * @version 4.0
 *
 * Generate Twitter Cards meta tags
 */

class ESSB_TwitterCards {

	/**
	 * Handle all meta sharing details
	 * @see class-metadetails.php
	 */
	private $meta_details = null;
	
	/**
	 * Indicate when we have image card to show also image
	 * @var boolean
	 */
	private $image_card = false;
	
	public function __construct() {
		
		if (!is_admin()) {
			$this->meta_details = new ESSB_FrontMetaDetails();
			
			add_action( 'essb_twittercard', array( $this, 'card' ), 1 );
			add_action( 'essb_twittercard', array( $this, 'details' ), 5 );
			
			add_action( 'wp_head', array( $this, 'twittercard' ), 1 );				
		}
		
	}
	
	/**
	 * Output open graph tags
	 */
	public function twittercard() {
		wp_reset_query();
	
		if ( ( defined( 'WP_DEBUG' ) && WP_DEBUG === true ) ) {
			echo '<!-- Twitter Cards generated by Easy Social Share Buttons for WordPress v'.ESSB3_VERSION.' - https://socialsharingplugin.com. You see this message only because you have debug mode ON -->'."\n";
		}
		
		$deactivate_trigger = false;
			
		if (essb_is_module_deactivated_on('sso') || essb_is_plugin_deactivated_on()) {
			$deactivate_trigger = true;
		}
			
		$deactivate_trigger = apply_filters('essb_deactivate_opengraph', $deactivate_trigger);
		
		if (!$deactivate_trigger) {
			do_action( 'essb_twittercard' );
		}
	}
	
	private function output_metatag( $name, $value, $escaped = false ) {
	
		// Escape the value if not escaped.
		if ( false === $escaped ) {
			$value = esc_attr( $value );
		}
	
		$metatag_key = apply_filters( 'essb_twitter_metatag_key', 'name' );
	
		// Output meta.
		echo '<meta ', esc_attr( $metatag_key ), '="twitter:', esc_attr( $name ), '" content="', esc_attr($value), '" />', "\n";
	}
	
	public function card() {
		$card_type = essb_option_value('twitter_card_type');
		
		if ($card_type == '') {
			$card_type = 'summary';
		}
		else if ($card_type == 'summaryimage') {
			$card_type = 'summary_large_image';
			$this->image_card = true;
		}
		
		$this->output_metatag('card', $card_type);
		
		$user = essb_option_value('twitter_card_user');
		if (!empty($user) && is_string($user)) {
			$this->output_metatag('site', $user);
		}
		
		$this->output_metatag('domain', get_bloginfo('name'));
	}
	
	public function details() {
		if (is_single() || is_page()) {
		    $post_details = ESSB_Runtime_Cache::get_post_sharing_data(get_the_ID());
		    
		    $twitter_description = $post_details->twittercard_value('description');
		    $twitter_title = $post_details->twittercard_value('title');
		    $twitter_image = $post_details->twittercard_value('image');
		    $twitter_url = $post_details->twittercard_value('url');
		    
			
			if (!empty($twitter_title)) {
			    $twitter_title = esc_html( wp_strip_all_tags( stripslashes( $twitter_title ), true ) );
				$this->output_metatag('title', $twitter_title);
				
			}
			if (!empty($twitter_description)) {
				$this->output_metatag('description', esc_attr($twitter_description));				
			}
			
			$this->output_metatag('url', $twitter_url);
			
			if (!empty($twitter_image) && is_string($twitter_image) && $this->image_card) {
				$this->output_metatag('image:src', esc_url($twitter_image));
			}
		}
	}
}