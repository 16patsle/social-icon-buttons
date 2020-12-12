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

  // Enable output buffering
  ob_start();

  $social_media = [
    'facebook' => [
      'url' => 'http://www.facebook.com/sharer.php?u=' . $url_current_page,
      'title' => esc_html__( 'Facebook', 'social-icon-buttons' ),
      'icon' => 'fa-facebook-f',
      'text' => esc_html__( 'Share using Facebook', 'social-icon-buttons' ),
    ],
    'twitter' => [
      'url' => 'http://twitter.com/share?url=' . $url_current_page . '&text=' . $share_text,
      'title' => esc_html__( 'Twitter', 'social-icon-buttons' ),
      'icon' => 'fa-twitter',
      'text' => esc_html__( 'Share using Twitter', 'social-icon-buttons' ),
    ],
    'pinterest' => [
      'url' => 'http://pinterest.com/pin/create/bookmarklet/?is_video=false&url=' . $url_current_page . '&media=' . $url_post_thumb . '&description=' . $str_page_title,
      'title' => esc_html__( 'Pinterest', 'social-icon-buttons' ),
      'icon' => 'fa-pinterest-p',
      'text' => esc_html__( 'Share using Pinterest', 'social-icon-buttons' ),
    ],
    'reddit' => [
      'url' => 'http://reddit.com/submit?url=' . $url_current_page . '&amp;title=' . $str_page_title,
      'title' => esc_html__( 'Reddit', 'social-icon-buttons' ),
      'icon' => 'fa-reddit-alien',
      'text' => esc_html__( 'Share using Reddit', 'social-icon-buttons' ),
    ],
    'pocket' => [
      'url' => 'https://getpocket.com/save?url=' . $url_current_page . '&amp;title=' . $str_page_title,
      'title' => esc_html__( 'Pocker', 'social-icon-buttons' ),
      'icon' => 'fa-get-pocket',
      'text' => esc_html__( 'Share using Pocket', 'social-icon-buttons' ),
    ],
    'telegram' => [
      'url' => 'https://telegram.me/share/url?url=' . $url_current_page . '&amp;text=' . $share_text,
      'title' => esc_html__( 'Telegram', 'social-icon-buttons' ),
      'icon' => 'fa-telegram-plane',
      'text' => esc_html__( 'Share using Telegram', 'social-icon-buttons' ),
    ],
    'email' => [
      'url' => 'mailto:?subject=' . $email_title . '&amp;body=' . $email_content . '%20' . $url_current_page,
      'title' => esc_html__( 'Email', 'social-icon-buttons' ),
      'icon' => 'fa-envelope',
      'text' => esc_html__( 'Share using email', 'social-icon-buttons' ),
    ],
  ];

  ?>
  <div class="social-icons">
    <?php
    foreach ( $social_media as $name => $social ) {
      ?>
        <a href="<?php echo $social['url']; ?>" class="<?php echo $name; ?>" target="_blank" rel="noopener" title="<?php echo $social['title']; ?>">
          <svg class="social" aria-hidden="true"><use xlink:href="#social-<?php echo $social['icon'] ?>"/></svg>
          <span><?php echo $social['text']; ?></span>
        </a>
        <?php
    }
    ?>
    <a href="#" onclick="window.print()" class="print" target="_blank" rel="noopener" title="<?php echo esc_html__( 'Print', 'social-icon-buttons' ); ?>">
      <svg class="social" aria-hidden="true"><use xlink:href="#social-fa-print"/></svg>
      <span><?php echo esc_html__( 'Print page', 'social-icon-buttons' ); ?></span>
    </a>
  </div>
  <?php

  // Get contents and clean buffer
  $share_buttons = ob_get_contents();
  ob_end_clean();

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

function add_icon_defs() {
  require_once plugin_dir_path( __FILE__ ) . '/inc/icons.php';
}
add_action( 'wp_body_open', 'add_icon_defs' );
