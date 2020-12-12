<?php
/*
Plugin Name: Social Icon Buttons Plugin
Description: Social Icon Buttons multitek.no
Version: 1.3.3
Author: Patrick Sletvold
Author URI: http://multitek.no
Requires at least: 4.6
Text Domain: social-icon-buttons
*/

declare( strict_types=1 );

/*
========
Includes
========
*/

require_once plugin_dir_path( __FILE__ ) . '/inc/social-icon-widget.php';

/*
=======
Filters
=======
*/

function add_social_icons( $content ): string {
  // Don't run the function unless we're on a page it applies to
  if ( ! is_single() ) {
    return $content;
  }

  // TODO: Find a better solution.
  if ( function_exists( 'is_amp_endpoint' ) ) {
    if ( is_amp_endpoint() ) {
      return $content;
    }
  }

  global $post;

  $url_current_page = get_permalink( $post->ID );
  $str_page_title = get_the_title( $post->ID );

  $share_text = urlencode(
    html_entity_decode(
      $str_page_title
      . ' - Multitek', ENT_COMPAT, 'UTF-8'
    )
  );
  $email_title = str_replace( '&', '%26', $str_page_title );
  $email_content = str_replace( '+', '%20', $str_page_title );

  if ( has_post_thumbnail() ) {
    // get the featured image
    $url_post_thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
    $url_post_thumb = $url_post_thumb[0];
  } else {
    // no featured image set
    // use the pinterest default
    $url_post_thumb = 'https://cdn.multitek.no/img/multitek-logo/logo_gjennomsiktig_facebook.png';
  }

  $share_buttons = '
	<div class="social-icons">
		<a href="http://www.facebook.com/sharer.php?u=' . $url_current_page . '" class="facebook" target="_blank" rel="noopener" title="' . esc_html__( 'Facebook', 'social-icon-buttons' ) . '"><i class="social fa fa-facebook" aria-hidden="true"></i><span>' . esc_html__( 'Share using Facebook', 'social-icon-buttons' ) . '</span></a>
		<a href="http://twitter.com/share?url=' . $url_current_page . '&text=' . $share_text . '" class="twitter" target="_blank" rel="noopener" title="' . esc_html__( 'Twitter', 'social-icon-buttons' ) . '"><i class="social fa fa-twitter" aria-hidden="true"></i><span>' . esc_html__( 'Share using Twitter', 'social-icon-buttons' ) . '</span></a>
    <a href="http://pinterest.com/pin/create/bookmarklet/?is_video=false&url=' . $url_current_page . '&media=' . $url_post_thumb . '&description=' . $str_page_title
   . '" class="pinterest" target="_blank" rel="noopener" title="' . esc_html__( 'Pinterest', 'social-icon-buttons' ) . '"><i class="social fa fa-pinterest-p" aria-hidden="true"></i><span>' . __( 'Share using Pinterest', 'social-icon-buttons' ) . '</span></a>
    <a href="http://reddit.com/submit?url=' . $url_current_page . '&amp;title=' . $str_page_title
   . '" class="reddit" target="_blank" rel="noopener" title="' . esc_html__( 'Reddit', 'social-icon-buttons' ) . '"><i class="social fa fa-reddit-alien" aria-hidden="true"></i><span>' . esc_html__( 'Share using Reddit', 'social-icon-buttons' ) . '</span></a>
    <a href="https://getpocket.com/save?url=' . $url_current_page . '&amp;title=' . $str_page_title
   . '" class="pocket" target="_blank" rel="noopener" title="' . esc_html__( 'Pocket', 'social-icon-buttons' ) . '"><i class="social fa fa-get-pocket" aria-hidden="true"></i><span>' . esc_html__( 'Save to Pocket', 'social-icon-buttons' ) . '</span></a>
		<a href="https://telegram.me/share/url?url=' . $url_current_page . '&amp;text=' . $share_text . '" class="telegram" target="_blank" title="' . esc_html__( 'Telegram', 'social-icon-buttons' ) . '"><i class="social fa fa-telegram" aria-hidden="true"></i><span>' . esc_html__( 'Share using Telegram', 'social-icon-buttons' ) . '</span></a>
		<a href="mailto:?subject=' . $email_title . '&amp;body=' . $email_content . '%20' . $url_current_page . '" class="email" target="_blank" rel="noopener" title="' . esc_html__( 'Email', 'social-icon-buttons' ) . '"><i class="social fa fa-envelope" aria-hidden="true"></i><span>' . esc_html__( 'Share using email', 'social-icon-buttons' ) . '</span></a>
		<a href="#" onclick="window.print()" class="print" target="_blank" rel="noopener" title="Print"><i class="social fa fa-print" aria-hidden="true" title="' . esc_html__( 'Print', 'social-icon-buttons' ) . '"></i><span>' . esc_html__( 'Print page', 'social-icon-buttons' ) . '</span></a>
	</div>
	';
  $return_content = $share_buttons . $content . $share_buttons;

  return $return_content;
}
add_filter( 'the_content', 'add_social_icons' );

/*
=======
Actions
=======
*/

function add_icon_stylesheet() {
  wp_register_style( 'social-icon-buttons', plugin_dir_url( __FILE__ ) . '/inc/social-icons.css' );
  wp_enqueue_style( 'social-icon-buttons' );
}
add_action( 'wp_enqueue_scripts', 'add_icon_stylesheet' );
