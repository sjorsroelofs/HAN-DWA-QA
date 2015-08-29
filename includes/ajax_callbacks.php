<?php

/**
 * AJAX callback to add a question
 * @param (POST/array) the POST data for the question
 * @return (void)
 */
function han_dwa_qa_ajax_new_question() {
    $result = array(
        'error' => false
    );

    if(!post_password_required()) {
        $result['error'] = !han_dwa_qa_add_question( $_POST, isset( $_POST['qa_id'] ) ? $_POST['qa_id'] : null );
    }

    echo json_encode( $result );
    exit;
}

/**
 * AJAX callback to upvote a question
 * @param (POST/array) the POST data wth the question ID
 * @return (void)
 */
function han_dwa_qa_ajax_upvote_question() {
    $result = array(
        'error' => false
    );

    if(!post_password_required()) {
        $result['error'] = !han_dwa_qa_upvote_question( isset( $_POST['question_id'] ) ? $_POST['question_id'] : null );
    }

    echo json_encode( $result );
    exit;
}