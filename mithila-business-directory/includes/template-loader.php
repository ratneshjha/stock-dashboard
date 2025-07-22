<?php
/**
 * Template loader for the Mithila Business Directory plugin.
 *
 * @package MithilaBusinessDirectory
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Load a template from the plugin's templates directory.
 *
 * @param string $template The path of the template to include.
 * @return string The path of the template to include.
 */
function mbd_template_loader( $template ) {
    if ( is_singular( 'mbd_business' ) ) {
        $new_template = plugin_dir_path( __FILE__ ) . '../templates/single-mbd_business.php';
        if ( '' !== $new_template ) {
            return $new_template;
        }
    } elseif ( is_post_type_archive( 'mbd_business' ) || is_tax( 'mbd_business_category' ) ) {
        $new_template = plugin_dir_path( __FILE__ ) . '../templates/archive-mbd_business.php';
        if ( '' !== $new_template ) {
            return $new_template;
        }
    }

    return $template;
}
add_filter( 'template_include', 'mbd_template_loader' );
