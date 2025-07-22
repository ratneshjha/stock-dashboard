<?php
/**
 * Plugin Name:       Mithila Business Directory
 * Plugin URI:        https://mithilaonline.com
 * Description:       A business directory plugin for mithilaonline.com.
 * Version:           1.0.0
 * Author:            Jules
 * Author URI:        https://mithilaonline.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mithila-business-directory
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * The core plugin class.
 */
require plugin_dir_path( __FILE__ ) . 'includes/post-types.php';
require plugin_dir_path( __FILE__ ) . 'includes/taxonomies.php';
require plugin_dir_path( __FILE__ ) . 'includes/shortcodes.php';
require plugin_dir_path( __FILE__ ) . 'includes/template-loader.php';
