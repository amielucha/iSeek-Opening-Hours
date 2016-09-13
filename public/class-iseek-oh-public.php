<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://amielucha.com/
 * @since      1.0.0
 *
 * @package    Iseek_Oh
 * @subpackage Iseek_Oh/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Iseek_Oh
 * @subpackage Iseek_Oh/public
 * @author     Slawomir Amielucha <amielucha@gmail.com>
 */
class Iseek_Oh_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Array of weekdays.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $weekdays    Array of weekdays.
	 */
	private static $weekdays = array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun');

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->weekdays = array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun');

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Iseek_Oh_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Iseek_Oh_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/iseek-oh-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Iseek_Oh_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Iseek_Oh_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/iseek-oh-public.js', array( 'jquery' ), $this->version, false );

	}



	public function get_opening_hours_on($day){
		$day = self::$weekdays[$day];
		$is_closed = get_option( 'iseek_opening_hours_' . $day . '_x' );

		if ($is_closed)
			return false;

		// If the day is not specified to be 'Closed', let's check if the conditions are met
		$opening = get_option( 'iseek_opening_hours_' . $day . '_o' );
		$closing = get_option( 'iseek_opening_hours_' . $day . '_c' );

		if(!$opening || !$closing)
			return false;

		return array($opening, $closing);
		// Convert 24:00 hour to 12:00 am:
		//return date("g:i a", strtotime($opening)) . ' &ndash; ' . date("g:i a", strtotime($closing));
	}

	/**
	 * Returns true if the shop is open on the given day and time.
	 */
	public function is_open_on($day, $hour){
		$opening_hours = self::get_opening_hours_on($day);
		return ( strtotime($opening_hours[0]) < strtotime($hour) && strtotime($hour) < strtotime($opening_hours[1]) ) ? true : false;
	}

	/**
	 * Function showing whether the business is open now.
	 */
	public function is_open() {
		// @TODO set as option
		date_default_timezone_set('Europe/Dublin');

		$now = date('w') - 1;
		$now_hour = date('H:i');

		return self::is_open_on($now, $now_hour);
	}

	public function closes_today_at() {
		// @TODO set as option
		date_default_timezone_set('Europe/Dublin');
		$now = date('w') - 1;
		$day = self::$weekdays[$now];

		return get_option( 'iseek_opening_hours_' . $day . '_c' );
	}

	/**
	 * This function renders the output of all opening hours
	 * specified in the plugin settings.
	 */
	public function render_output() {
		//$weekdays = array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun');
		$weekdays = self::$weekdays;
		$weekdayNames = array(__('Monday', 'iseek-oh'), __('Tuesday', 'iseek-oh') ,__('Wednesday', 'iseek-oh') ,__('Thursday', 'iseek-oh') ,__('Friday', 'iseek-oh') ,__('Saturday', 'iseek-oh') ,__('Sunday', 'iseek-oh') );
		$weekdaysSchema = array('Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su');

		// @TODO: Consider setting the itemtype as option
		$output  = "<div class='iseek-opening-hours-container' iteemscope itemmtype='http://schema.org/LocalBusiness'>";
		$output .= "<span itemprop='name' style='display: none'>" . get_bloginfo('name') . "</span>";
		foreach ($weekdays as $key => $day ) {

			$opening_hours = self::get_opening_hours_on($key);

			$output .= "<div class='iseek-opening-hours-day'>";
			$output .= "<span class='iseek-opening-hours-label'>" . $weekdayNames[$key] . " </span>";
			$output .= "<span class='iseek-opening-hours-hours'>";

			if ( $opening_hours ){
				$hours = date("g:i a", strtotime($opening_hours[0])) . ' &ndash; ' . date("g:i a", strtotime($opening_hours[1]));
				$output .= '<span itemprop="openingHours" content="'. $weekdaysSchema[$key] . ' ' . $opening . '-' . $closing .'">' . $hours . '</span>';
			} else {
				$output .= __('Closed', 'iseek-oh');
			}

			$output .= "</span>";
			$output .= "</div>";
		}

		$output .= "</div>";

		return $output;
	}
}

if ( ! function_exists( 'get_iseek_opening_hours' ) ) {
  function get_iseek_opening_hours() {
		return Iseek_Oh_Public::render_output();
  }
}

if ( ! function_exists( 'iseek_opening_hours' ) ) {
  function iseek_opening_hours() {
		echo get_iseek_opening_hours();
  }
}

if ( ! function_exists( 'get_iseek_is_open' ) ) {
  function get_iseek_is_open() {
		return ( Iseek_Oh_Public::is_open() ) ? '<div class="iseek-opening-hours-is-open">' . __('We are open today until ', 'iseek-oh') . Iseek_Oh_Public::closes_today_at() . '</div>' : '<div class="iseek-opening-hours-is-open">' . __('We are closed now.', 'iseek-oh') . '</div>';
  }
}

if ( ! function_exists( 'iseek_is_open' ) ) {
  function iseek_is_open() {
  	echo get_iseek_is_open();
  }
}
