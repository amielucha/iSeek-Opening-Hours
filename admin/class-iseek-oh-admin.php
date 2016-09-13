<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://amielucha.com/
 * @since      1.0.0
 *
 * @package    Iseek_Oh
 * @subpackage Iseek_Oh/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Iseek_Oh
 * @subpackage Iseek_Oh/admin
 * @author     Slawomir Amielucha <amielucha@gmail.com>
 */
class Iseek_Oh_Admin {

	/**
	 * The options name to be used in this plugin
	 *
	 * @since  	1.0.0
	 * @access 	private
	 * @var  	string 		$option_name 	Option name of this plugin
	 */
	private $option_name = 'iseek_opening_hours';

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/iseek-oh-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/iseek-oh-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */

		public function add_options_page() {

		$this->plugin_screen_hook_suffix = add_options_page(
			__( 'Opening Hours Settings', 'iseek-oh' ),
			__( 'Opening Hours', 'iseek-oh' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);

	}

	/**
	 * Render the options page for plugin
	 *
	 * @since  1.0.0
	 */
	public function display_options_page() {
		include_once 'partials/iseek-oh-admin-display.php';
	}

	/**
	 * Register Settings for the options page
	 *
	 * @since  1.0.0
	 */
	public function register_setting() {
		// Add a General section
		add_settings_section(
			$this->option_name . '_general',
			__( 'General', 'iseek-oh' ),
			array( $this, $this->option_name . '_general_cb' ),
			$this->plugin_name
		);

		// Add the field with the names and function to use for our new
	 	// settings, put it in our new section
	 	$weekdays = array('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun');
	 	$weekdayNames = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

	 	foreach ($weekdays as $key => $day ) {
	 		add_settings_field(
				$this->option_name . '_' . $day . '_x',
				__( $weekdayNames[$key], 'iseek-oh' ),
				array( $this, $this->option_name . '_' . $day . '_x_cb' ),
				$this->plugin_name,
				$this->option_name . '_general',
				array( 'label_for' => $this->option_name . '_' . $day . '_x' )
			);

			add_settings_field(
				$this->option_name . '_' . $day . '_o',
				__( $weekdayNames[$key] .' opening', 'iseek-oh' ),
				array( $this, $this->option_name . '_' . $day . '_o_cb' ),
				$this->plugin_name,
				$this->option_name . '_general',
				array( 'label_for' => $this->option_name . '_' . $day . '_o' )
			);

			add_settings_field(
				$this->option_name . '_' . $day . '_c',
				__( $weekdayNames[$key] .' closing', 'iseek-oh' ),
				array( $this, $this->option_name . '_' . $day . '_c_cb' ),
				$this->plugin_name,
				$this->option_name . '_general',
				array( 'label_for' => $this->option_name . '_' . $day . '_c' )
			);

			register_setting( $this->plugin_name, $this->option_name . '_' . $day . '_x' );
			register_setting( $this->plugin_name, $this->option_name . '_' . $day . '_o', array( $this, $this->option_name . '_sanitize_hour' ) );
			register_setting( $this->plugin_name, $this->option_name . '_' . $day . '_c', array( $this, $this->option_name . '_sanitize_hour' ) );

	 	}

		/*add_settings_field(
			$this->option_name . '_monday_x',
			__( 'Monday', 'iseek-oh' ),
			array( $this, $this->option_name . '_monday_x_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_monday_x' )
		);

	 	add_settings_field(
			$this->option_name . '_monday_o',
			__( 'Monday opening', 'iseek-oh' ),
			array( $this, $this->option_name . '_monday_o_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_monday_o' )
		);

		add_settings_field(
			$this->option_name . '_monday_c',
			__( 'Monday closing', 'iseek-oh' ),
			array( $this, $this->option_name . '_monday_c_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_monday_c' )
		);*/

		/*
		register_setting( $this->plugin_name, $this->option_name . '_monday_x' );
		register_setting( $this->plugin_name, $this->option_name . '_monday_o', array( $this, $this->option_name . '_sanitize_hour' ) );
		register_setting( $this->plugin_name, $this->option_name . '_monday_c', array( $this, $this->option_name . '_sanitize_hour' ) );
		*/
	}

	/**
	 * Sanitize the time
	 *
	 * @param  string $position $_POST value
	 * @since  1.0.0
	 * @return string           Sanitized value
	 */
		public function iseek_opening_hours_sanitize_hour( $input ) {
			$dateObj = DateTime::createFromFormat('d.m.Y H:i', "10.10.2010 " . $input);
			$decomposed = explode(":", $input);
			$hour = intval($decomposed[0], 10);

			if ($dateObj !== false && $hour <= 24 ) {
			   return $input;
			}
		}

	/**
	 * Render the text for the general section
	 * Lazy solution, but it works for this purpose.
	 *
	 * @since  1.0.0
	 */
	public function iseek_opening_hours_general_cb() {
		echo '<p>' . __( 'Enter the time in the correct 24-hour format. For example <code>10:00</code> or <code>17:15</code>.', 'iseek-oh' ) . '</p>';
	}

	/*public function iseek_opening_hours_x_cb($day) {
	 	echo '<input name="' . $this->option_name . '_' . $day . '_x' . '" id="' . $this->option_name . '_' . $day . '_x' . '" type="checkbox" value="1" class="code" ' . checked( 1, get_option( $this->option_name . '_' . $day . '_x' ), false ) . ' /> Closed';
	}*/

	public function iseek_opening_hours_mon_x_cb() {
	 	echo '<input name="' . $this->option_name . '_mon_x' . '" id="' . $this->option_name . '_mon_x' . '" type="checkbox" value="1" class="code" ' . checked( 1, get_option( $this->option_name . '_mon_x' ), false ) . ' /> Closed';
	}

	public function iseek_opening_hours_mon_o_cb() {
			echo '<input value="' . get_option( $this->option_name . '_mon_o' ) . '" size="5" maxlength="5" placeholder="hh:mm" type="time" name="' . $this->option_name . '_mon_o' . '" id="' . $this->option_name . '_mon_o' . '">';
	}

	public function iseek_opening_hours_mon_c_cb() {
			echo '<input value="' . get_option( $this->option_name . '_mon_c' ) . '" size="5" maxlength="5" placeholder="hh:mm" type="time" name="' . $this->option_name . '_mon_c' . '" id="' . $this->option_name . '_mon_c' . '">';
	}


	public function iseek_opening_hours_tue_x_cb() {
	 	echo '<input name="' . $this->option_name . '_tue_x' . '" id="' . $this->option_name . '_tue_x' . '" type="checkbox" value="1" class="code" ' . checked( 1, get_option( $this->option_name . '_tue_x' ), false ) . ' /> Closed';
	 }

	public function iseek_opening_hours_tue_o_cb() {
			echo '<input value="' . get_option( $this->option_name . '_tue_o' ) . '" size="5" maxlength="5" placeholder="hh:mm" type="time" name="' . $this->option_name . '_tue_o' . '" id="' . $this->option_name . '_tue_o' . '">';
	}

	public function iseek_opening_hours_tue_c_cb() {
			echo '<input value="' . get_option( $this->option_name . '_tue_c' ) . '" size="5" maxlength="5" placeholder="hh:mm" type="time" name="' . $this->option_name . '_tue_c' . '" id="' . $this->option_name . '_tue_c' . '">';
	}


	public function iseek_opening_hours_wed_x_cb() {
	 	echo '<input name="' . $this->option_name . '_wed_x' . '" id="' . $this->option_name . '_wed_x' . '" type="checkbox" value="1" class="code" ' . checked( 1, get_option( $this->option_name . '_wed_x' ), false ) . ' /> Closed';
	 }

	public function iseek_opening_hours_wed_o_cb() {
			echo '<input value="' . get_option( $this->option_name . '_wed_o' ) . '" size="5" maxlength="5" placeholder="hh:mm" type="time" name="' . $this->option_name . '_wed_o' . '" id="' . $this->option_name . '_wed_o' . '">';
	}

	public function iseek_opening_hours_wed_c_cb() {
			echo '<input value="' . get_option( $this->option_name . '_wed_c' ) . '" size="5" maxlength="5" placeholder="hh:mm" type="time" name="' . $this->option_name . '_wed_c' . '" id="' . $this->option_name . '_wed_c' . '">';
	}


	public function iseek_opening_hours_thu_x_cb() {
	 	echo '<input name="' . $this->option_name . '_thu_x' . '" id="' . $this->option_name . '_thu_x' . '" type="checkbox" value="1" class="code" ' . checked( 1, get_option( $this->option_name . '_thu_x' ), false ) . ' /> Closed';
	 }

	public function iseek_opening_hours_thu_o_cb() {
			echo '<input value="' . get_option( $this->option_name . '_thu_o' ) . '" size="5" maxlength="5" placeholder="hh:mm" type="time" name="' . $this->option_name . '_thu_o' . '" id="' . $this->option_name . '_thu_o' . '">';
	}

	public function iseek_opening_hours_thu_c_cb() {
			echo '<input value="' . get_option( $this->option_name . '_thu_c' ) . '" size="5" maxlength="5" placeholder="hh:mm" type="time" name="' . $this->option_name . '_thu_c' . '" id="' . $this->option_name . '_thu_c' . '">';
	}


	public function iseek_opening_hours_fri_x_cb() {
	 	echo '<input name="' . $this->option_name . '_fri_x' . '" id="' . $this->option_name . '_fri_x' . '" type="checkbox" value="1" class="code" ' . checked( 1, get_option( $this->option_name . '_fri_x' ), false ) . ' /> Closed';
	 }

	public function iseek_opening_hours_fri_o_cb() {
			echo '<input value="' . get_option( $this->option_name . '_fri_o' ) . '" size="5" maxlength="5" placeholder="hh:mm" type="time" name="' . $this->option_name . '_fri_o' . '" id="' . $this->option_name . '_fri_o' . '">';
	}

	public function iseek_opening_hours_fri_c_cb() {
			echo '<input value="' . get_option( $this->option_name . '_fri_c' ) . '" size="5" maxlength="5" placeholder="hh:mm" type="time" name="' . $this->option_name . '_fri_c' . '" id="' . $this->option_name . '_fri_c' . '">';
	}


	public function iseek_opening_hours_sat_x_cb() {
	 	echo '<input name="' . $this->option_name . '_sat_x' . '" id="' . $this->option_name . '_sat_x' . '" type="checkbox" value="1" class="code" ' . checked( 1, get_option( $this->option_name . '_sat_x' ), false ) . ' /> Closed';
	 }

	public function iseek_opening_hours_sat_o_cb() {
			echo '<input value="' . get_option( $this->option_name . '_sat_o' ) . '" size="5" maxlength="5" placeholder="hh:mm" type="time" name="' . $this->option_name . '_sat_o' . '" id="' . $this->option_name . '_sat_o' . '">';
	}

	public function iseek_opening_hours_sat_c_cb() {
			echo '<input value="' . get_option( $this->option_name . '_sat_c' ) . '" size="5" maxlength="5" placeholder="hh:mm" type="time" name="' . $this->option_name . '_sat_c' . '" id="' . $this->option_name . '_sat_c' . '">';
	}


	public function iseek_opening_hours_sun_x_cb() {
	 	echo '<input name="' . $this->option_name . '_sun_x' . '" id="' . $this->option_name . '_sun_x' . '" type="checkbox" value="1" class="code" ' . checked( 1, get_option( $this->option_name . '_sun_x' ), false ) . ' /> Closed';
	 }

	public function iseek_opening_hours_sun_o_cb() {
			echo '<input value="' . get_option( $this->option_name . '_sun_o' ) . '" size="5" maxlength="5" placeholder="hh:mm" type="time" name="' . $this->option_name . '_sun_o' . '" id="' . $this->option_name . '_sun_o' . '">';
	}

	public function iseek_opening_hours_sun_c_cb() {
			echo '<input value="' . get_option( $this->option_name . '_sun_c' ) . '" size="5" maxlength="5" placeholder="hh:mm" type="time" name="' . $this->option_name . '_sun_c' . '" id="' . $this->option_name . '_sun_c' . '">';
	}
}
