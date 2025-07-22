<form id="mbd-submission-form" action="" method="post">
    <?php wp_nonce_field( 'mbd_submit_business', 'mbd_business_nonce' ); ?>
    <p>
        <label for="mbd-business-name"><?php _e( 'Business Name', 'mithila-business-directory' ); ?></label>
        <input type="text" id="mbd-business-name" name="mbd-business-name" required>
    </p>
    <p>
        <label for="mbd-business-description"><?php _e( 'Business Description', 'mithila-business-directory' ); ?></label>
        <textarea id="mbd-business-description" name="mbd-business-description" rows="5" required></textarea>
    </p>
    <p>
        <label for="mbd-business-category"><?php _e( 'Business Category', 'mithila-business-directory' ); ?></label>
        <?php
        wp_dropdown_categories(
            array(
                'taxonomy'        => 'mbd_business_category',
                'name'            => 'mbd-business-category',
                'hierarchical'    => true,
                'show_option_all' => __( 'Select a category', 'mithila-business-directory' ),
            )
        );
        ?>
    </p>
    <p>
        <input type="submit" name="mbd-submit" value="<?php _e( 'Submit Business', 'mithila-business-directory' ); ?>">
    </p>
</form>
