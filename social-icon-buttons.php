<?php
/*
Plugin Name: Social Icon Buttons Plugin
Description: Social Icon Buttons multitek.no
Version: 1.2
Author: Multitek
Author URI: http://multitek.no
*/

/*
========
Includes
========
*/

include_once plugin_dir_path(__FILE__).'/social-icon-widget.php';

/*
=======
Filters
=======
*/

function add_social_icons( $content ) {
    // Don't run the function unless we're on a page it applies to
	if ( ! is_single() )
		return $content;

	global $post;

	$urlCurrentPage = get_permalink($post->ID);
	$strPageTitle = get_the_title($post->ID);
	$shareText = urlencode(html_entity_decode($strPageTitle . ' - Multitek', ENT_COMPAT, 'UTF-8'));
	$emailTitle = str_replace('&', '%26', $strPageTitle);
	$emailContent = str_replace('+', '%20', $strPageTitle);

	if(has_post_thumbnail()) {
        // get the featured image
        $urlPostThumb = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
        $urlPostThumb = $urlPostThumb[0];
    }
    // no featured image set
    else {
        // use the pinterest default
        $urlPostThumb = 'https://cdn.multitek.no/img/multitek-logo/logo_gjennomsiktig_facebook.png';
    }

	$share_buttons = '
	<div class="social-icons">
		<a href="http://www.facebook.com/sharer.php?u=' . $urlCurrentPage . '" class="facebook" target="_blank" title="Facebook"><i class="social fa fa-facebook" aria-hidden="true"></i></a>
		<a href="http://twitter.com/share?url=' . $urlCurrentPage . '&text=' . $shareText . '" class="twitter" target="_blank" title="Twitter"><i class="social fa fa-twitter" aria-hidden="true"></i></a>
		<a href="https://plus.google.com/share?url=' . $urlCurrentPage . '" class="google-plus" target="_blank" title="Google+"><i class="social fa fa-google-plus" aria-hidden="true"></i></a>
		<a href="http://pinterest.com/pin/create/bookmarklet/?is_video=false&url=' . $urlCurrentPage . '&media=' . $urlPostThumb . '&description=' . $strPageTitle . '" class="pinterest" target="_blank" title="Pinterest"><i class="social fa fa-pinterest-p" aria-hidden="true"></i></a>
		<a href="http://reddit.com/submit?url=' . $urlCurrentPage  . '&amp;title=' . $strPageTitle . '" class="reddit" target="_blank" title="Reddit"><i class="social fa fa-reddit-alien" aria-hidden="true"></i></a>
		<a href="https://getpocket.com/save?url=' . $urlCurrentPage  . '&amp;title=' . $strPageTitle . '" class="pocket" target="_blank" title="Pocket"><i class="social fa fa-get-pocket" aria-hidden="true"></i></a>
		<a href="mailto:?subject=' . $emailTitle . '&amp;body=' . $emailContent . '%20' . $urlCurrentPage  . '" class="email" target="_blank" title="Email"><i class="social fa fa-envelope" aria-hidden="true"></i></a>
		<a href="#" onclick="window.print()" class="print" target="_blank"><i class="social fa fa-print" aria-hidden="true" title="Print"></i></a>
	</div>
	';
	$returnContent = $share_buttons . $content . $share_buttons;

    return $returnContent;
}
add_filter( 'the_content', 'add_social_icons' );

/*
=======
Actions
=======
*/

function add_icon_stylesheet() {
	wp_register_style( 'social-icon-buttons',  plugin_dir_url( __FILE__ ) . '/social-icons.css' );
    wp_enqueue_style( 'social-icon-buttons' );
}
add_action( 'wp_enqueue_scripts', 'add_icon_stylesheet' );

?>