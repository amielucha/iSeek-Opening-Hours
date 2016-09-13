<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://amielucha.com/
 * @since      0.1.0
 *
 * @package    Iseek_Oh
 * @subpackage Iseek_Oh/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      0.1.0
 * @package    Iseek_Oh
 * @subpackage Iseek_Oh/includes
 * @author     Slawomir Amielucha <amielucha@gmail.com>
 */
class Iseek_Oh_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.1.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'iseek-oh',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
