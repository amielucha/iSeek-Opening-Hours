<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://amielucha.com/
 * @since             0.1.0
 * @package           Iseek_Oh
 *
 * @wordpress-plugin
 * Plugin Name:       iSeek Opening Hours
 * Plugin URI:        http://iseek.ie/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           0.1.0
 * Author:            Slawomir Amielucha
 * Author URI:        https://amielucha.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       iseek-oh
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-iseek-oh-activator.php
 */
function activate_iseek_oh() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-iseek-oh-activator.php';
	Iseek_Oh_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-iseek-oh-deactivator.php
 */
function deactivate_iseek_oh() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-iseek-oh-deactivator.php';
	Iseek_Oh_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_iseek_oh' );
register_deactivation_hook( __FILE__, 'deactivate_iseek_oh' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-iseek-oh.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1.0
 */
function run_iseek_oh() {

	$plugin = new Iseek_Oh();
	$plugin->run();

}
run_iseek_oh();
