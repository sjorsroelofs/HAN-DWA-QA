<?php

// Register the hook
register_activation_hook( __FILE__, 'han_dwa_qa_setup_database' );

/**
 * Setup the database
 * @return (void)
 */
function han_dwa_qa_setup_database() {
    han_dwa_qa_create_qa_question_relation_table();
    han_dwa_qa_create_question_vote_table();
}

/**
 * Create a custom database table for the Q&A->Question relations
 * @return (void)
 */
function han_dwa_qa_create_qa_question_relation_table() {
    global $wpdb;

    $charsetCollate = $wpdb->get_charset_collate();

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    $tableName   = $wpdb->prefix . HAN_DWA_QA_QUESTION_RELATION_TABLE_NAME;
    $sql         = "CREATE TABLE $tableName (
        qa_id mediumint(9) NOT NULL,
        question_id mediumint(9) NOT NULL,
        PRIMARY KEY  (qa_id, question_id)
    ) $charsetCollate;";

    dbDelta( $sql );

    add_option( 'han_dwa_qa_question_relation_db_version', HAN_DWA_QA_QUESTION_RELATION_DB_VERSION );
}

/**
 * Create a custom database table for the Question votes
 * @return (void)
 */
function han_dwa_qa_create_question_vote_table() {
    global $wpdb;

    $charsetCollate = $wpdb->get_charset_collate();

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    $tableName   = $wpdb->prefix . HAN_DWA_QA_QUESTION_VOTES_TABLE_NAME;
    $sql         = "CREATE TABLE $tableName (
        question_id mediumint(9) NOT NULL,
        ip_address VARCHAR(40) NULL,
        PRIMARY KEY  (question_id, ip_address)
    ) $charsetCollate;";

    dbDelta( $sql );

    add_option( 'han_dwa_qa_question_votes_db_version', HAN_DWA_QA_QUESTION_VOTES_DB_VERSION );
}

/**
 * Check if our database needs an update
 * @return (void)
 */
function han_dwa_qa_check_database() {
    if(get_site_option( 'han_dwa_qa_question_relation_db_version' ) != HAN_DWA_QA_QUESTION_RELATION_DB_VERSION) han_dwa_qa_setup_database();
    elseif(get_site_option( 'han_dwa_qa_question_votes_db_version' ) != HAN_DWA_QA_QUESTION_VOTES_DB_VERSION) han_dwa_qa_setup_database();
}

/**
 * On the deletion of a post
 * @param (int) the post ID
 * @return (void)
 */
function han_dwa_post_deleted( $postId ) {
    if((bool)get_post_status( $postId )) {
        switch(get_post_type( $postId )) {
            case HAN_DWA_QA_CPT : han_dwa_qa_clear_database_qa( $postId ); break;
            case HAN_DWA_QA_QUESTION_CPT : han_dwa_qa_clear_database_question( $postId ); break;
        }
    }
}

/**
 * Clear the database when a Q&A gets deleted
 * @param (int) the post ID
 * @return (void)
 */
function han_dwa_qa_clear_database_qa( $postId ) {
    global $wpdb;

    $tableName   = $wpdb->prefix . HAN_DWA_QA_CLASS_RELATION_TABLE_NAME;
    $sql         = "SELECT `question_id` FROM $tableName WHERE `qa_id` = '$postId'";

    // Delete the questions
    foreach($wpdb->get_results( $sql ) as $question) wp_delete_post( $question->question_id, true );

    // Delete the relations in the relations table
    $wpdb->delete( $tableName, array( 'qa_id' => $postId ) );
}

/**
 * Clear the database when a question gets deleted
 * @param (int) the post ID
 * @return (void)
 */
function han_dwa_qa_clear_database_question( $postId ) {
    global $wpdb;

    $tableName = $wpdb->prefix . HAN_DWA_QA_CLASS_RELATION_TABLE_NAME;
    $wpdb->delete( $tableName, array( 'question_id' => $postId ) );

    $tableName = $wpdb->prefix . HAN_DWA_QA_QUESTION_VOTES_TABLE_NAME;
    $wpdb->delete( $tableName, array( 'question_id' => $postId ) );
}