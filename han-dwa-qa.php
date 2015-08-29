<?php

/**
 * Plugin Name: HAN DWA Q&A
 * Description: HAN DWA Q&A plugin
 * Version: 1.0
 * Author: Sjors Roelofs
 * Author URI: http://www.sjors.io
 */

// Include some files
require_once( 'classes/question.class.php' );
require_once( 'includes/database_setup.php' );
require_once( 'includes/post_types_and_taxonomies.php' );
require_once( 'includes/ajax_callbacks.php' );

// Set some constants
define( 'HAN_DWA_QA_CPT', 'han_dwa_qa' );
define( 'HAN_DWA_QA_CLASS_TAX', 'han_dwa_qa_class' );
define( 'HAN_DWA_QA_QUESTION_CPT', 'han_dwa_qa_question' );

define( 'HAN_DWA_QA_QUESTION_RELATION_TABLE_NAME', 'han_dwa_qa_question_relations' );
define( 'HAN_DWA_QA_QUESTION_RELATION_DB_VERSION', '1.0' );

define( 'HAN_DWA_QA_QUESTION_VOTES_TABLE_NAME', 'han_dwa_qa_question_votes' );
define( 'HAN_DWA_QA_QUESTION_VOTES_DB_VERSION', '1.0' );

// Include the meta boxes
require_once( 'includes/meta_boxes/qa_asked_questions.php' );
require_once( 'includes/meta_boxes/question_details.php' );


// Let's crank it up!
han_dwa_qa_init();
register_activation_hook( __FILE__, 'han_dwa_qa_reset_permalinks' );


/**
 * Initialization
 * @return (void)
 */
function han_dwa_qa_init() {
    add_action( 'init', 'han_dwa_qa_register_cpt_tax' );
    add_action( 'plugins_loaded', 'han_dwa_qa_check_database' );
    add_action( 'delete_post', 'han_dwa_post_deleted' );
    add_action( 'wp_enqueue_scripts', 'han_dwa_qa_add_styles_scripts' );
    add_action( 'manage_' . HAN_DWA_QA_QUESTION_CPT . '_posts_custom_column', 'han_dwa_qa_question_admin_columns_content', 10, 2 );
    add_action( 'manage_' . HAN_DWA_QA_CPT . '_posts_custom_column', 'han_dwa_qa_admin_columns_content', 10, 2 );

    add_action( 'wp_ajax_han_dwa_qa_ajax_new_question', 'han_dwa_qa_ajax_new_question' );
    add_action( 'wp_ajax_nopriv_han_dwa_qa_ajax_new_question', 'han_dwa_qa_ajax_new_question' );
    add_action( 'wp_ajax_han_dwa_qa_ajax_upvote_question', 'han_dwa_qa_ajax_upvote_question' );
    add_action( 'wp_ajax_nopriv_han_dwa_qa_ajax_upvote_question', 'han_dwa_qa_ajax_upvote_question' );

    add_filter( 'the_content', 'han_dwa_qa_modify_the_content' );
    add_filter( 'manage_edit-' . HAN_DWA_QA_QUESTION_CPT . '_columns', 'han_dwa_qa_add_question_admin_columns' );
    add_filter( 'manage_edit-' . HAN_DWA_QA_CPT . '_columns', 'han_dwa_qa_add_qa_admin_columns' );
}

/**
 * Reset permalinks
 * @return (void)
 */
function han_dwa_qa_reset_permalinks() {
    han_dwa_qa_init();
    flush_rewrite_rules();
}

/**
 * Add styles and scripts
 */
function han_dwa_qa_add_styles_scripts() {
    wp_enqueue_style( 'dashicons' );
    wp_enqueue_style( 'han_dwa_qa_styles', plugin_dir_url( __FILE__ ) . 'assets/css/han_dwa_qa_styles.css', null, '1.0.0' );

    wp_enqueue_script( 'han_dwa_qa_scripts', plugin_dir_url( __FILE__ ) . 'assets/js/han_dwa_qa_scripts.js', array( 'jquery' ), '1.0.0' );
    wp_localize_script( 'han_dwa_qa_scripts', 'han_dwa_qa_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}

/**
 * Add a new question and chain it to a Q&A
 * @param (array) an array with the question fields
 * @param (int) the Q&A post ID
 * @return (bool) true on success, false on error
 */
function han_dwa_qa_add_question( $questionData = null, $qaId = null ) {
    if($qaId && (bool)get_post_status( intval( $qaId ) ) && han_dwa_qa_validate_question_data( $questionData ) && han_dwa_qa_is_email_unique_for_qa( intval( $qaId ), sanitize_email( $questionData['email'] ) )) {
        $questionId = wp_insert_post( array(
            'post_content'   => wp_kses_post( nl2br( $questionData['question'] ) ),
            'post_title'     => 'Vraag van ' . sanitize_text_field( $questionData['name'] ),
            'post_status'    => 'publish',
            'post_type'      => HAN_DWA_QA_QUESTION_CPT
        ) );

        if($questionId > 0) {
            global $wpdb;

            add_post_meta( $questionId, 'han_dwa_qa_question_name', sanitize_text_field( $questionData['name'] ) );
            add_post_meta( $questionId, 'han_dwa_qa_question_email', sanitize_email( $questionData['email'] ) );
            add_post_meta( $questionId, 'han_dwa_qa_question_reference', wp_kses_post( nl2br( $questionData['reference'] ) ) );

            return (bool)$wpdb->insert(
                $wpdb->prefix . HAN_DWA_QA_QUESTION_RELATION_TABLE_NAME,
                array(
                    'qa_id'         => intval( $qaId ),
                    'question_id'   => intval( $questionId )
                )
            );
        }
    }

    return false;
}

/**
 * Check if an email address hasn't already submitted a question to a specific Q&A
 * @return (bool) true when not submitted
 */
function han_dwa_qa_is_email_unique_for_qa( $qaId, $email ) {
    $isValid = true;

    foreach(han_dwa_qa_get_questions_for_qa( $qaId ) as $question) {
        if($question->getEmail() === $email) {
            $isValid = false;
            break;
        }
    }

    return $isValid;
}

/**
 * Validate a question
 * @param (array) an array with the question fields
 * @return (bool) true on valid, false on invalid
 */
function han_dwa_qa_validate_question_data( $questionData ) {
    $requiredFields = array( 'name', 'email', 'question', 'reference' );

    foreach($requiredFields as $requiredKey) {
        if(!in_array( $requiredKey, (array)array_keys( $questionData ) ) || empty( $questionData[$requiredKey] )) {
            return false;
        }
    }

    return true;
}

/**
 * Get the questions for a Q&A
 * @param (int) the Q&A ID
 * @return ([question]) an array with question objects
 */
function han_dwa_qa_get_questions_for_qa( $qaId ) {
    global $wpdb;

    $result      = array();
    $tableName   = $wpdb->prefix . HAN_DWA_QA_QUESTION_RELATION_TABLE_NAME;
    $sql         = "SELECT `question_id` FROM `$tableName` WHERE `qa_id` = '$qaId'";

    foreach($wpdb->get_results( $sql ) as $questionRelation) {
        $question = new Question( $questionRelation->question_id );
        if($question->question_exists()) $result[] = $question;
    }

    usort( $result, function( $a, $b ) {
        if($a->getVotes() == $b->getVotes()) return 0;
        return $a->getVotes() < $b->getVotes() ? -1 : 1;
    } );

    $result = array_reverse( $result );

    return $result;
}

/**
 * Modify the wp_content to show our plugin additions
 * @param (string) the post content
 * @return (string) the modified post content
 */
function han_dwa_qa_modify_the_content( $content ) {
    if(get_post_type() === HAN_DWA_QA_CPT && !post_password_required() && is_single()) {
        // Create the HTML
        ob_start();
        echo '<div id="han_dwa_qa_questions">';
            require( 'partials/asked_questions.php' );
            require( 'partials/new_question_form.php' );
        echo '</div>';

        $content .= ob_get_clean();
        ob_end_flush();
    }

    return $content;
}

/**
 * Upvote a question
 * @param (int) the question ID
 * @return (bool) true on success, false on error
 */
function han_dwa_qa_upvote_question( $questionId ) {
    global $wpdb;

    if((bool)get_post_status( $questionId )) {
        $ipAddress   = $_SERVER['REMOTE_ADDR'];
        $tableName   = $wpdb->prefix . HAN_DWA_QA_QUESTION_VOTES_TABLE_NAME;
        $sql         = "SELECT COUNT(*) FROM `$tableName` WHERE `question_id` = '$questionId' AND `ip_address` = '$ipAddress'";

        if(intval( $wpdb->get_var( $sql ) ) === 0) {
            return (bool)$wpdb->insert(
                $tableName,
                array(
                    'question_id'   => $questionId,
                    'ip_address'    => $ipAddress
                )
            );
        }
    }

    return false;
}