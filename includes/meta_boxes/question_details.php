<?php

$hanDwaQaQuestionDetailsActionId    = 'han_dwa_qa_question_details_meta_box';
$hanDwaQaQuestionDetailsNonceId     = 'han_dwa_qa_question_details_meta_box_nonce';
$hanDwaQaQuestionDetailsValueId     = 'han_dwa_qa_question_details_meta_box_value';
$hanDwaQaQuestionDetailsPostTypes   = array( HAN_DWA_QA_QUESTION_CPT );


/**
 * Create a custom meta box
 * @return (void)
 */
function han_dwa_qa_question_details_meta_box() {
    global $hanDwaQaQuestionDetailsPostTypes;

    foreach($hanDwaQaQuestionDetailsPostTypes as $postType) {
        add_meta_box(
            'han_dwa_qa_question_details_meta_box_identifier' . '-' . $postType,
            'Details',
            'han_dwa_qa_question_details_meta_box_callback',
            $postType,
            'normal',
            'default'
        );
    }
}
add_action( 'admin_init', 'han_dwa_qa_question_details_meta_box' );

/**
 * Callback after creating the meta box
 * @param (object) the post object
 * @return (void)
 */
function han_dwa_qa_question_details_meta_box_callback( $post ) {
    global $hanDwaQaQuestionDetailsActionId;
    global $hanDwaQaQuestionDetailsNonceId;

    // Set a nonce
    wp_nonce_field( $hanDwaQaQuestionDetailsActionId, $hanDwaQaQuestionDetailsNonceId );

    // Prepare the content
    $question = new Question( $post->ID );

    // Output
    include_once( 'question_details_html.php' );
}

/**
 * Save the data
 * @param (int) the post ID
 * @return (void)
 */
function han_dwa_qa_question_details_meta_box_save( $postId ) {
    global $hanDwaQaQuestionDetailsNonceId;
    global $hanDwaQaQuestionDetailsActionId;
    global $hanDwaQaQuestionDetailsValueId;
    global $hanDwaQaQuestionDetailsPostTypes;

    // Check if there is a nonce and if it is valid
    if(!isset( $_POST[$hanDwaQaQuestionDetailsNonceId] )) return;
    if(!wp_verify_nonce( $_POST[$hanDwaQaQuestionDetailsNonceId], $hanDwaQaQuestionDetailsActionId )) return;

    // Do nothing on autosave
    if(defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE) return;

    // Check if the user is allowed to edit
    if(isset( $_POST['post_type'] ) && in_array( $_POST['post_type'], $hanDwaQaQuestionDetailsPostTypes )) {
        if(!current_user_can( 'edit_post', $postId )) return;
    }

    // Save the data
    update_post_meta( $postId, 'han_dwa_qa_question_name', $_POST['question-name'] );
    update_post_meta( $postId, 'han_dwa_qa_question_email', $_POST['question-email'] );
    update_post_meta( $postId, 'han_dwa_qa_question_reference', $_POST['question-reference'] );
}
add_action( 'save_post', 'han_dwa_qa_question_details_meta_box_save' );