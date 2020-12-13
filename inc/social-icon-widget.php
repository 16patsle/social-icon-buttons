<?php

declare( strict_types=1 );

// Creating the widget
class Social_Icon_Widget extends WP_Widget {
  public function __construct() {
    parent::__construct(
      // Base ID of your widget
      'Social_Icon_Widget',
      // Widget name will appear in UI
      __( 'Social Icon Widget', 'social-icon-buttons' ),
      // Widget description
      [ 'description' => __( 'Social Icon Buttons Widget', 'social-icon-buttons' ) ]
    );
  }

  // Creating widget front-end
  // This is where the action happens
  public function widget( $args, $instance ): void {
    $title = isset( $instance['title'] ) ? $instance['title'] : '';
    $title = apply_filters( 'widget_title', $title );

    // before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if ( ! empty( $title ) ) {
      echo $args['before_title'] . $title . $args['after_title'];
    }

    $social_media = [
      'facebook' => [
        'url' => 'https://facebook.com/',
        'instance' => isset( $instance['facebook'] ) ? $instance['facebook'] : false,
        'title' => esc_html__( 'Facebook', 'social-icon-buttons' ),
        'icon' => 'fa-facebook-f',
        'text' => esc_html__( 'Facebook Page', 'social-icon-buttons' ),
      ],
      'twitter' => [
        'url' => 'https://twitter.com/',
        'instance' => isset( $instance['twitter'] ) ? $instance['twitter'] : false,
        'title' => esc_html__( 'Twitter', 'social-icon-buttons' ),
        'icon' => 'fa-twitter',
        'text' => esc_html__( 'Twitter Profile', 'social-icon-buttons' ),
      ],
      'pinterest' => [
        'url' => 'http://pinterest.com/',
        'instance' => isset( $instance['pinterest'] ) ? $instance['pinterest'] : false,
        'title' => esc_html__( 'Pinterest', 'social-icon-buttons' ),
        'icon' => 'fa-pinterest-p',
        'text' => esc_html__( 'Pinterest Profile', 'social-icon-buttons' ),
      ],
      'feedly' => [
        'url' => '',
        'instance' => isset( $instance['feedly'] ) ? $instance['feedly'] : false,
        'title' => esc_html__( 'Feedly', 'social-icon-buttons' ),
        'icon' => 'fa-rss',
        'text' => esc_html__( 'Feedly RSS Feed', 'social-icon-buttons' ),
      ],
      'email' => [
        'url' => 'mailto:',
        'instance' => isset( $instance['email'] ) ? $instance['email'] : false,
        'title' => esc_html__( 'Email', 'social-icon-buttons' ),
        'icon' => 'fa-envelope',
        'text' => esc_html__( 'Send email', 'social-icon-buttons' ),
      ],
    ];

    // This is where you run the code and display the output
    ?>
    <div class="social-icons" style="max-width:100%;">
      <?php
      foreach ( $social_media as $name => $social ) {
        if ( ! empty( $social['instance'] ) ) {
          ?>
            <a href="<?php echo $social['url'] . $social['instance']; ?>" class="social-icon-button <?php echo $name; ?>" target="_blank" rel="noopener" title="<?php echo $social['title']; ?>">
              <svg class="social" aria-hidden="true"><use xlink:href="#social-<?php echo $social['icon'] ?>"/></svg>
              <span><?php echo $social['text']; ?></span>
            </a>
          <?php
        }
      }

      if ( isset( $instance['print'] ) && ! empty( $instance['print'] ) ) {
        $print = $instance['print'];
        ?>
        <button type="button" onclick="window.print()" class="social-icon-button print" title="<?php echo esc_html__( 'Print', 'social-icon-buttons' ); ?>">
          <svg class="social" aria-hidden="true"><use xlink:href="#social-fa-print"/></svg>
          <span><?php echo esc_html__( 'Print page', 'social-icon-buttons' ); ?></span>
        </button>
        <?php
      }
      ?>
    </div>
    <?php

    echo $args['after_widget'];
    /*
    $social_icon_buttons = '
    <div class="social-icons">
        <a href="#" class="facebook" target="_blank" title="Facebook"><i class="social fa fa-facebook" aria-hidden="true"></i></a>
        <a href="#" class="twitter" target="_blank" title="Twitter"><i class="social fa fa-twitter" aria-hidden="true"></i></a>
        <a href="#" class="pinterest" target="_blank" title="Pinterest"><i class="social fa fa-pinterest-p" aria-hidden="true"></i></a>
        <a href="#" class="reddit" target="_blank" title="Reddit"><i class="social fa fa-reddit-alien" aria-hidden="true"></i></a>
        <a href="#" class="email" target="_blank" title="Email"><i class="social fa fa-envelope" aria-hidden="true"></i></a>
        <a href="#" onclick="window.print()" class="print" target="_blank"><i class="social fa fa-print" aria-hidden="true" title="Print"></i></a>
    </div>
    ';
    */
    //echo $social_icon_buttons;
  }

  // Widget Backend
  public function form( $instance ): void {
    if ( isset( $instance['title'] ) ) {
      $title = $instance['title'];
    } else {
      $title = __( 'New title', 'social-icon-buttons' );
    }

    if ( isset( $instance['facebook'] ) ) {
      $facebook = $instance['facebook'];
    } else {
      $facebook = '';
    }

    if ( isset( $instance['twitter'] ) ) {
      $twitter = $instance['twitter'];
    } else {
      $twitter = '';
    }

    if ( isset( $instance['pinterest'] ) ) {
      $pinterest = $instance['pinterest'];
    } else {
      $pinterest = '';
    }

    if ( isset( $instance['feedly'] ) ) {
      $feedly = $instance['feedly'];
    } else {
      $feedly = '';
    }

    if ( isset( $instance['email'] ) ) {
      $email = $instance['email'];
    } else {
      $email = '';
    }

    if ( isset( $instance['print'] ) ) {
      $print = $instance['print'];
    } else {
      $print = '';
    }

    // Widget admin form
    ?>
    <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'social-icon-buttons' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>"
                        type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e( 'Facebook:', 'social-icon-buttons' ); ?></label>
        <p>facebook.com/</p>
        <input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>"
                        type="text" value="<?php echo esc_attr( $facebook ); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'Twitter:', 'social-icon-buttons' ); ?></label>
        <p>twitter.com/</p>
        <input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>"
                        type="text" value="<?php echo esc_attr( $twitter ); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'pinterest' ); ?>"><?php _e( 'Pinterest:', 'social-icon-buttons' ); ?></label>
        <p>pinterest.com/</p>
        <input class="widefat" id="<?php echo $this->get_field_id( 'pinterest' ); ?>" name="<?php echo $this->get_field_name( 'pinterest' ); ?>"
                        type="text" value="<?php echo esc_attr( $pinterest ); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'feedly' ); ?>"><?php _e( 'Feedly:', 'social-icon-buttons' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'feedly' ); ?>" name="<?php echo $this->get_field_name( 'feedly' ); ?>"
                        type="text" value="<?php echo esc_attr( $feedly ); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'Email:', 'social-icon-buttons' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>"
                        type="text" value="<?php echo esc_attr( $email ); ?>" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id( 'print' ); ?>"><?php _e( 'Print:', 'social-icon-buttons' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'print' ); ?>" name="<?php echo $this->get_field_name( 'print' ); ?>"
                        type="text" value="<?php echo esc_attr( $print ); ?>" />
    </p>
    <?php
  }

  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ): array {
    $instance = [];
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

    $instance['facebook'] = ( ! empty( $new_instance['facebook'] ) ) ? strip_tags( $new_instance['facebook'] ) : '';
    $instance['twitter'] = ( ! empty( $new_instance['twitter'] ) ) ? strip_tags( $new_instance['twitter'] ) : '';
    $instance['pinterest'] = ( ! empty( $new_instance['pinterest'] ) ) ? strip_tags( $new_instance['pinterest'] ) : '';
    $instance['feedly'] = ( ! empty( $new_instance['feedly'] ) ) ? strip_tags( $new_instance['feedly'] ) : '';
    $instance['email'] = ( ! empty( $new_instance['email'] ) ) ? strip_tags( $new_instance['email'] ) : '';
    $instance['print'] = ( ! empty( $new_instance['print'] ) ) ? strip_tags( $new_instance['print'] ) : '';

    return $instance;
  }

} // Class wpb_widget ends here

// Register and load the widget
function social_icon_load_widget(): void {
  register_widget( 'Social_Icon_Widget' );
}
add_action( 'widgets_init', 'social_icon_load_widget' );

?>
