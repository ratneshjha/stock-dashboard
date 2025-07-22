<?php
/**
 * Shortcodes for the Mithila Business Directory plugin.
 *
 * @package MithilaBusinessDirectory
 */

if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Register the [mbd_submission_form] shortcode.
 */
function mbd_submission_form_shortcode() {
    $message = '';
    if ( isset( $_POST['mbd-submit'] ) ) {
        $message = mbd_handle_form_submission();
    }

    ob_start();
    if ( ! empty( $message ) ) {
        echo '<div class="mbd-message">' . esc_html( $message ) . '</div>';
    }
    include plugin_dir_path( __FILE__ ) . '../templates/submission-form.php';
    return ob_get_clean();
}
add_shortcode( 'mbd_submission_form', 'mbd_submission_form_shortcode' );

/**
 * Handle the form submission.
 */
function mbd_handle_form_submission() {
    if ( ! isset( $_POST['mbd_business_nonce'] ) || ! wp_verify_nonce( $_POST['mbd_business_nonce'], 'mbd_submit_business' ) ) {
        return __( 'Nonce verification failed.', 'mithila-business-directory' );
    }

    if ( ! current_user_can( 'publish_posts' ) ) {
        return __( 'You do not have permission to publish businesses.', 'mithila-business-directory' );
    }

    if ( ! isset( $_POST['mbd-business-name'] ) || ! isset( $_POST['mbd-business-description'] ) || ! isset( $_POST['mbd-business-category'] ) ) {
        return __( 'Please fill out all required fields.', 'mithila-business-directory' );
    }

    $business_name = sanitize_text_field( $_POST['mbd-business-name'] );
    $business_description = sanitize_textarea_field( $_POST['mbd-business-description'] );
    $business_category = intval( $_POST['mbd-business-category'] );

    $new_post = array(
        'post_title'   => $business_name,
        'post_content' => $business_description,
        'post_status'  => 'publish',
        'post_type'    => 'mbd_business',
    );

    $post_id = wp_insert_post( $new_post );

    if ( is_wp_error( $post_id ) ) {
        return $post_id->get_error_message();
    }

    wp_set_object_terms( $post_id, $business_category, 'mbd_business_category' );

    return __( 'Business submitted successfully!', 'mithila-business-directory' );
}
