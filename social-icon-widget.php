<?php

// Creating the widget
class Social_Icon_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
// Base ID of your widget
'Social_Icon_Widget',

// Widget name will appear in UI
__('Social Icon Widget', 'social-icon-buttons'),

// Widget description
array( 'description' => __('Social Icon Buttons Widget', 'social-icon-buttons'), )
);
    }

// Creating widget front-end
// This is where the action happens
public function widget($args, $instance)
{
    $title = apply_filters('widget_title', $instance['title']);
// before and after widget arguments are defined by themes
echo $args['before_widget'];
    if (! empty($title)) {
        echo $args['before_title'] . $title . $args['after_title'];
    }

// This is where you run the code and display the output
echo '<div class="social-icons" style="max-width:100%;">';

    $facebook = $instance['facebook'];
    if (! empty($facebook)) {
        echo '<a href="https://facebook.com/' . $facebook . '" class="facebook" target="_blank" title="' . esc_html__('Facebook', 'social-icon-buttons') . '"><i class="social fa fa-facebook" aria-hidden="true"></i><span>' . esc_html__('Facebook Page', 'social-icon-buttons') . '</span></a>';
    }

    $twitter = $instance['twitter'];
    if (! empty($twitter)) {
        echo '<a href="https://twitter.com/' . $twitter . '" class="twitter" target="_blank" title="' . esc_html__('Twitter', 'social-icon-buttons') . '"><i class="social fa fa-twitter" aria-hidden="true"></i><span>' . esc_html__('Twitter Profile', 'social-icon-buttons') . '</span></a>';
    }

    $googleplus = $instance['googleplus'];
    if (! empty($googleplus)) {
        echo '<a href="https://plus.google.com/' . $googleplus . '" class="google-plus" target="_blank" title="' . esc_html__('Google+', 'social-icon-buttons') . '"><i class="social fa fa-google-plus" aria-hidden="true"></i><span>' . esc_html__('Google+ Profile', 'social-icon-buttons') . '</span></a>';
    }

    $pinterest = $instance['pinterest'];
    if (! empty($pinterest)) {
        echo '<a href="https://pinterest.com/' . $pinterest . '" class="pinterest" target="_blank" title="' . esc_html__('Pinterest', 'social-icon-buttons') . '"><i class="social fa fa-pinterest-p" aria-hidden="true"></i><span>' . esc_html__('Pinterest Profile', 'social-icon-buttons') . '</span></a>';
    }

    $feedly = $instance['feedly'];
    if (! empty($googleplus)) {
        echo '<a href="' . $feedly . '" class="feedly" target="_blank" title="' . esc_html__('Feedly', 'social-icon-buttons') . '"><i class="social fa fa-rss" aria-hidden="true"></i><span>' . esc_html__('Feedly RSS Feed', 'social-icon-buttons') . '</span></a>';
    }

    $email = $instance['email'];
    if (! empty($email)) {
        echo '<a href="mailto:' . $email . '" class="email" target="_blank" title="' . esc_html__('Email', 'social-icon-buttons') . '"><i class="social fa fa-envelope" aria-hidden="true"></i><span>' . esc_html__('Send email', 'social-icon-buttons') . '</span></a>';
    }

    $print = $instance['print'];
    if (! empty($print)) {
        echo '<a href="#" onclick="window.print()" class="print" target="_blank" title="' . esc_html__('Print', 'social-icon-buttons') . '"><i class="social fa fa-print" aria-hidden="true" title="Print"></i><span>' . esc_html__('Print page', 'social-icon-buttons') . '</span></a>';
    }

    echo '</div>';

    echo $args['after_widget'];
/*
    $social_icon_buttons = '
    <div class="social-icons">
        <a href="#" class="facebook" target="_blank" title="Facebook"><i class="social fa fa-facebook" aria-hidden="true"></i></a>
        <a href="#" class="twitter" target="_blank" title="Twitter"><i class="social fa fa-twitter" aria-hidden="true"></i></a>
        <a href="#" class="google-plus" target="_blank" title="Google+"><i class="social fa fa-google-plus" aria-hidden="true"></i></a>
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
public function form($instance)
{
    if (isset($instance[ 'title' ])) {
        $title = $instance[ 'title' ];
    } else {
        $title = __('New title', 'social-icon-buttons');
    }

    if (isset($instance[ 'facebook' ])) {
        $facebook = $instance[ 'facebook' ];
    } else {
        $facebook = '';
    }

    if (isset($instance[ 'twitter' ])) {
        $twitter = $instance[ 'twitter' ];
    } else {
        $twitter = '';
    }

    if (isset($instance[ 'googleplus' ])) {
        $googleplus = $instance[ 'googleplus' ];
    } else {
        $googleplus = '';
    }

    if (isset($instance[ 'pinterest' ])) {
        $pinterest = $instance[ 'pinterest' ];
    } else {
        $pinterest = '';
    }

    if (isset($instance[ 'feedly' ])) {
        $feedly = $instance[ 'feedly' ];
    } else {
        $feedly = '';
    }

    if (isset($instance[ 'email' ])) {
        $email = $instance[ 'email' ];
    } else {
        $email = '';
    }

    if (isset($instance[ 'print' ])) {
        $print = $instance[ 'print' ];
    } else {
        $print = '';
    }
// Widget admin form
?>
	<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'social-icon-buttons'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>"
						type="text" value="<?php echo esc_attr($title); ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook:', 'social-icon-buttons'); ?></label>
		<p>facebook.com/</p>
		<input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>"
						type="text" value="<?php echo esc_attr($facebook); ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter:', 'social-icon-buttons'); ?></label>
		<p>twitter.com/</p>
		<input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>"
						type="text" value="<?php echo esc_attr($twitter); ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('googleplus'); ?>"><?php _e('Google+:', 'social-icon-buttons'); ?></label>
		<p>plus.google.com/</p>
		<input class="widefat" id="<?php echo $this->get_field_id('googleplus'); ?>" name="<?php echo $this->get_field_name('googleplus'); ?>"
						type="text" value="<?php echo esc_attr($googleplus); ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('pinterest'); ?>"><?php _e('Pinterest:', 'social-icon-buttons'); ?></label>
		<p>pinterest.com/</p>
		<input class="widefat" id="<?php echo $this->get_field_id('pinterest'); ?>" name="<?php echo $this->get_field_name('pinterest'); ?>"
						type="text" value="<?php echo esc_attr($pinterest); ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('feedly'); ?>"><?php _e('Feedly:', 'social-icon-buttons'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('feedly'); ?>" name="<?php echo $this->get_field_name('feedly'); ?>"
						type="text" value="<?php echo esc_attr($feedly); ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('email'); ?>"><?php _e('Email:', 'social-icon-buttons'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>"
						type="text" value="<?php echo esc_attr($email); ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('print'); ?>"><?php _e('Print:', 'social-icon-buttons'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('print'); ?>" name="<?php echo $this->get_field_name('print'); ?>"
						type="text" value="<?php echo esc_attr($print); ?>" />
	</p>
	<?php
}

// Updating widget replacing old instances with new
public function update($new_instance, $old_instance)
{
    $instance = array();
    $instance['title'] = (! empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';

    $instance['facebook'] = (! empty($new_instance['facebook'])) ? strip_tags($new_instance['facebook']) : '';
    $instance['twitter'] = (! empty($new_instance['twitter'])) ? strip_tags($new_instance['twitter']) : '';
    $instance['googleplus'] = (! empty($new_instance['googleplus'])) ? strip_tags($new_instance['googleplus']) : '';
    $instance['pinterest'] = (! empty($new_instance['pinterest'])) ? strip_tags($new_instance['pinterest']) : '';
    $instance['feedly'] = (! empty($new_instance['feedly'])) ? strip_tags($new_instance['feedly']) : '';
    $instance['email'] = (! empty($new_instance['email'])) ? strip_tags($new_instance['email']) : '';
    $instance['print'] = (! empty($new_instance['print'])) ? strip_tags($new_instance['print']) : '';

    return $instance;
}
} // Class wpb_widget ends here

// Register and load the widget
function social_icon_load_widget()
{
    register_widget('Social_Icon_Widget');
}
add_action('widgets_init', 'social_icon_load_widget');

?>
