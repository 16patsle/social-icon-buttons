<?php
/*
Plugin Name: Social Icon Buttons Plugin
Description: Social Icon Buttons multitek.no
Version: 1.4.0
Author: Patrick Sletvold
Author URI: http://multitek.no
Requires at least: 4.6
Text Domain: social-icon-buttons
*/

declare( strict_types=1 );

class Social_Icon_Plugin {
  const VERSION = '1.4.0';
  const MINIFY = true;

  public function __construct() {
    add_filter( 'the_content', [ $this, 'add_social_icons' ] );

    add_action( 'wp_enqueue_scripts', [ $this, 'add_icon_stylesheet_script' ] );
    add_action( 'wp_body_open', [ $this, 'add_icon_defs' ] );
    add_action( 'widgets_init', [ $this, 'social_icon_load_widget' ] );
  }

  function add_social_icons( $content ): string {
    // Don't run the function unless we're on a page it applies to
    if ( ! is_single() || function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
      return $content;
    }

    global $post;

    $url_current_page = get_permalink( $post->ID );
    $str_page_title = get_the_title( $post->ID );
    $site_title = get_bloginfo( 'name' );

    $share_text = urlencode(
      html_entity_decode( $str_page_title . ' - ' . $site_title, ENT_COMPAT, 'UTF-8' )
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
          <a href="<?php echo $social['url']; ?>" class="social-icon-button <?php echo $name; ?>" target="_blank" rel="noopener" title="<?php echo $social['title']; ?>">
            <svg class="social" aria-hidden="true"><use xlink:href="#social-<?php echo $social['icon']; ?>"/></svg>
            <span><?php echo $social['text']; ?></span>
          </a>
          <?php
      }
      ?>
      <button type="button" onclick="window.print()" class="social-icon-button print" title="<?php echo esc_html__( 'Print', 'social-icon-buttons' ); ?>">
        <svg class="social" aria-hidden="true"><use xlink:href="#social-fa-print"/></svg>
        <span><?php echo esc_html__( 'Print page', 'social-icon-buttons' ); ?></span>
      </button>
      <button type="button" class="social-icon-button share" title="<?php echo esc_html__( 'Share', 'social-icon-buttons' ); ?>" data-title="<?php echo $site_title; ?>" data-text="<?php echo $str_page_title . ' - ' . $site_title; ?>" data-url="<?php echo $url_current_page; ?>">
        <svg class="social" aria-hidden="true"><use xlink:href="#social-fa-share-square"/></svg>
        <span><?php echo esc_html__( 'Share page', 'social-icon-buttons' ); ?></span>
      </button>
    </div>
    <?php

    // Get contents and clean buffer
    $share_buttons = ob_get_contents();
    ob_end_clean();

    $return_content = $share_buttons . $content . $share_buttons;

    return $return_content;
  }

  function add_icon_stylesheet_script() {
    wp_enqueue_style( 'social-icon-buttons', plugin_dir_url( __FILE__ ) . 'inc/social-icons' . ( self::MINIFY ? '.min' : '' ) . '.css', [], self::VERSION );
    wp_enqueue_script( 'social-icon-buttons', plugin_dir_url( __FILE__ ) . 'inc/social-icons' . ( self::MINIFY ? '.min' : '' ) . '.js', [], self::VERSION );
  }

  function add_icon_defs() {
    require_once plugin_dir_path( __FILE__ ) . '/inc/icons' . ( self::MINIFY ? '.min' : '' ) . '.html';
  }

  // Register and load the widget
  function social_icon_load_widget(): void {
    require_once plugin_dir_path( __FILE__ ) . '/inc/social-icon-widget.php';
    register_widget( 'Social_Icon_Widget' );
  }
}

new Social_Icon_Plugin();
