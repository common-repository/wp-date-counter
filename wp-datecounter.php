<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
Plugin Name: WordPress Date Counter
Plugin URI: http://justinrains.com/
Description: Allows a date counter widget to be displayed in your themes widget areas.
Version: 1.1
Author: Justin Rains
Author URI: http://justinrains.com/
*/
class wp_date_counter extends WP_Widget {
    // constructor
    public function __construct() {
        /* Widget settings. */
        $widget_ops = array(
            'classname' => 'wp-date-counter', 
            'description' => 'A widget that shows the number of days since a date.' );

        /* Widget control settings. */
        $control_ops = array(
            'width' => 300,
            'height' => 40,
            'id_base' => 'wp-datecounter-widget'
        );

        /* Create the widget. */
        parent::__construct(
            'wp-date-counter',
            'Days Counter',
            $widget_ops
        );
    }
    /**
     * Outputs the content of the widget.
     * @param $args
     * @param $instance
     */
    public function widget($args, $instance) {
        extract($args);
        extract($instance);

        $beforetext = $instance['beforetext'];// get_option('beforetext');
        $aftertext = $instance['aftertext1'];
	$title = $instance['title'];
        $month1 = $instance['month1'];// get_option('month1');
        $day1 = $instance['day1'];// get_option('day1');
        $year1 = $instance['year1'];// get_option('year1');
        echo $args[$itlte];
	if ($title == '') {
		$title = "Date Counter";
	}
        
        echo $before_widget;
        echo $before_title . $title . $after_title; 
        
        if ($beforetext) {
                printf('<div class="wp-date-counter wp-date-counter-widget-top">%s</div>', $beforetext);
        }

        if ($year1 != "") {
            $now = time();
            $your_date = strtotime($year1."-".$month1."-".$day1);
            $datediff = $now - $your_date;  
            $days = number_format(round($datediff / (60 * 60 * 24)));
        }

        printf('<div class="wp-date-counter wp-date-counter-widget-middle">%s</div>', $days);
        if ($aftertext) {
                printf('<div class="date-counter wp-date-counter-widget-bottom">%s</div>', $aftertext);
        }

        // Closing wrapper tag
//        echo '</div>';

        // This always needs to go at the end.
        echo $after_widget; 
    }

function activate_date_counter() {
//  add_option('date_counter_id', 'sprite-16');
}

function deactivate_date_counter() {
//  delete_option('date_counter_id');
}

function admin_init_date_counter() {
//  register_setting('date_counter_id', 'date_counter_id');
}

function admin_menu_date_manager() {
  add_options_page(
          'Date Counter', 'The Days Counter', 
          'manage_options', 'wp_date_counter', 'options_page_wp_date_counter'
  );
}

function admin_register_countdown_styles() {
    $my_css_ver = date("ymd-Gis", filemtime( plugin_dir_path( __FILE__ ) . '/css/date-counter.css' ));
     
    wp_register_style( 'date_counter_css',    plugins_url( '/css/date-counter.css',    __FILE__ ), false,   $my_css_ver );
    wp_enqueue_style ( 'date_counter_css' );
}

function options_page_wp_date() {
//  include(WP_PLUGIN_DIR.'/wp-date/options.php');  
//  http://codex.wordpress.org/Function_Reference/plugins_url
  include(plugins_url.'wp-date/options.php');
}

// widget form creation
public function form($instance) {
    // jQuery
    wp_enqueue_script('jquery');
    // This will enqueue the Media Uploader script
    wp_enqueue_media();

// Check values
    if( $instance) {
        $title = esc_attr( $instance['title'] );
        $beforetext = esc_attr( $instance['beforetext'] );
        $aftertext1 = ! empty( $instance['aftertext1'] ) ? $instance['aftertext1'] : esc_html__( 'Days', 'text_domain' );
        $month1 = $instance['month1'];
        $day1 = $instance['day1'];
        $year1 = $instance['year1'];
    } else {
        $title = 'Days Counter';
        $beforetext = 'I am';
        $aftertext1 = 'Days!!';
        $month1 = 1;//date('n');
        $day1 = 1;//date('j');
        $year1 = date('Y');
    }
?>
<p>
<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wp_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id('beforetext'); ?>"><?php _e('Before Text:', 'wp_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('beforetext'); ?>" name="<?php echo $this->get_field_name('beforetext'); ?>" type="text" value="<?php echo $beforetext; ?>" />
</p>
<p>
    <label for="soberdate"><span id="soberdate">Date:</span></label><br />
<?php
   echo "<select id=\"" . $this->get_field_id('month1') . "\" name=\"". $this->get_field_name('month1'). "\">\n";
    for ($x = 1; $x <= 12; $x++) {
        if ($month1 == $x) {
            $selected = " selected";
        } else {
            $selected = "";
        }
        echo "<option value=\"".$x."\"".$selected.">".$x."</option>\n";
    }
    echo "</select>\n";
    echo " <select id=\"" . $this->get_field_id('day1') . "\" name=\"" . $this->get_field_name('day1') . "\">\n";
    for ($x = 1; $x <= 31; $x++) {
        if ($day1 == $x) {
            $selected = " selected";
        } else {
            $selected = "";
        }
        echo "<option value=\"".$x."\"".$selected.">".$x."</option>\n";
    }
    echo "</select>\n";
    echo " <select name=\"" . $this->get_field_name('year1') . "\">\n";
    for ($x = 1970; $x <= date('Y'); $x++) {
        if ($year1 == $x) {
            $selected = " selected";
        } else {
            $selected = "";
        }
        echo "<option value=\"".$x."\"".$selected.">".$x."</option>\n";
    }
    echo "</select>\n";
?>
</p>
<p>
<label for="<?php echo $this->get_field_id('aftertext1'); ?>"><?php _e('After Text:', 'wp_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('aftertext1'); ?>" name="<?php echo $this->get_field_name('aftertext1'); ?>" type="text" value="<?php echo $aftertext1; ?>" />
</p>
<p>
<?php
if ($year1 != "") {
    $now = time();
    $your_date = strtotime($year1."-".$month1."-".$day1);
    $datediff = $now - $your_date;  
    echo round($datediff / (60 * 60 * 24));
}
?>
</p>
<?php
    }
    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            $instance['beforetext'] = ( ! empty( $new_instance['beforetext'] ) ) ? strip_tags( $new_instance['beforetext'] ) : '';
            $instance['aftertext1'] = ( ! empty( $new_instance['aftertext1'] ) ) ? strip_tags( $new_instance['aftertext1'] ) : '';
            $instance['month1'] = ( ! empty( $new_instance['month1'] ) ) ? strip_tags( $new_instance['month1'] ) : '';
            $instance['day1'] = ( ! empty( $new_instance['day1'] ) ) ? strip_tags( $new_instance['day1'] ) : '';
            $instance['year1'] = ( ! empty( $new_instance['year1'] ) ) ? strip_tags( $new_instance['year1'] ) : '';

            return $instance;
    }
}

function register_date_counter_widget() {
    register_widget( 'wp_date_counter' );
}

//register_activation_hook(__FILE__, 'activate_date_counter');
register_deactivation_hook(__FILE__, 'deactivate_date_counter');

add_action( 'widgets_init', 'register_date_counter_widget' );
?>
