<?php

$hanDwaQaAskedQuestionsActionId    = 'han_dwa_qa_asked_questions_meta_box';
$hanDwaQaAskedQuestionsNonceId     = 'han_dwa_qa_asked_questions_meta_box_nonce';
$hanDwaQaAskedQuestionsValueId     = 'han_dwa_qa_asked_questions_meta_box_value';
$hanDwaQaAskedQuestionsPostTypes   = array( HAN_DWA_QA_CPT );


/**
 * Create a custom meta box
 * @return (void)
 */
function han_dwa_qa_asked_questions_meta_box() {
    if(isset( $_GET['post'] )) {
        global $hanDwaQaAskedQuestionsPostTypes;

        foreach($hanDwaQaAskedQuestionsPostTypes as $postType) {
            add_meta_box(
                'han_dwa_qa_asked_questions_meta_box_identifier' . '-' . $postType,
                __( 'Posted items', 'han-dwa-qa' ),
                'han_dwa_qa_asked_questions_meta_box_callback',
                $postType,
                'normal',
                'default'
            );
        }
    }
}
add_action( 'admin_init', 'han_dwa_qa_asked_questions_meta_box' );

/**
 * Callback after creating the meta box
 * @param (object) the post object
 * @return (void)
 */
function han_dwa_qa_asked_questions_meta_box_callback( $post ) {
    global $hanDwaQaAskedQuestionsActionId;
    global $hanDwaQaAskedQuestionsNonceId;

    // Set a nonce
    wp_nonce_field( $hanDwaQaAskedQuestionsActionId, $hanDwaQaAskedQuestionsNonceId );

    // Prepare the content
    $questions = han_dwa_qa_get_questions_for_qa( $post->ID );

    // Output
    include_once( 'qa_asked_questions_html.php' );
}