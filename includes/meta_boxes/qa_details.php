<?php

$hanDwaQaDetailsActionId    = 'han_dwa_qa_details_meta_box';
$hanDwaQaDetailsNonceId     = 'han_dwa_qa_details_meta_box_nonce';
$hanDwaQaDetailsValueId     = 'han_dwa_qa_details_meta_box_value';
$hanDwaQaDetailsPostTypes   = array( HAN_DWA_QA_CPT );


/**
 * Create a custom meta box
 * @return (void)
 */
function han_dwa_qa_details_meta_box() {
    global $hanDwaQaDetailsPostTypes;

    foreach($hanDwaQaDetailsPostTypes as $postType) {
        add_meta_box(
            'han_dwa_qa_details_meta_box_identifier' . '-' . $postType,
            __( 'Details', 'han-dwa-qa' ),
            'han_dwa_qa_details_meta_box_callback',
            $postType,
            'side',
            'default'
        );
    }
}
add_action( 'admin_init', 'han_dwa_qa_details_meta_box' );

/**
 * Callback after creating the meta box
 * @param (object) the post object
 * @return (void)
 */
function han_dwa_qa_details_meta_box_callback( $post ) {
    global $hanDwaQaDetailsActionId;
    global $hanDwaQaDetailsNonceId;

    // Set a nonce
    wp_nonce_field( $hanDwaQaDetailsActionId, $hanDwaQaDetailsNonceId );

    // Prepare the date
    $quesitonAmount = han_dwa_qa_get_qa_question_amount( $post->ID );

    // Output
    include_once( 'qa_details_html.php' );
}

/**
 * Save the data
 * @param (int) the post ID
 * @return (void)
 */
function han_dwa_qa_details_meta_box_save( $postId ) {
    global $hanDwaQaDetailsNonceId;
    global $hanDwaQaDetailsActionId;
    global $hanDwaQaDetailsValueId;
    global $hanDwaQaDetailsPostTypes;

    // Check if there is a nonce and if it is valid
    if(!isset( $_POST[$hanDwaQaDetailsNonceId] )) return;
    if(!wp_verify_nonce( $_POST[$hanDwaQaDetailsNonceId], $hanDwaQaDetailsActionId )) return;

    // Do nothing on autosave
    if(defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) return;

    // Check if the user is allowed to edit
    if(isset( $_POST['post_type'] ) && in_array( $_POST['post_type'], $hanDwaQaDetailsPostTypes )) {
        if(!current_user_can( 'edit_post', $postId )) return;
    }

    // Save the data
    update_post_meta( $postId, 'han_dwa_qa_question_amount', $_POST['question-amount'] );
}
add_action( 'save_post', 'han_dwa_qa_details_meta_box_save' );