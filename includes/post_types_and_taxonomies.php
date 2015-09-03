<?php

/**
 * Register custom post types and taxonomies
 * @return (void)
 */
function han_dwa_qa_register_cpt_tax() {
    // Create the Q&A post type
    $qaCptArgs = array(
        'public'         => true,
        'rewrite'        => array(
            'slug'   => 'Q&A'
        ),
        'has_archive'    => true,
        'hierarchical'   => false,
        'supports'       => array( 'title', 'editor' ),
        'menu_icon'      => 'dashicons-megaphone',
        'labels'         => array(
            'name'                 => __( "Q&A's", 'han-dwa-qa' ),
    		'singular_name'        => __( 'Q&A', 'han-dwa-qa' ),
    		'menu_name'            => __( "Q&A's", 'han-dwa-qa' ),
    		'name_admin_bar'       => __( 'Q&A', 'han-dwa-qa' ),
    		'add_new'              => __( 'Add new Q&A', 'han-dwa-qa' ),
    		'add_new_item'         => __( 'Add new Q&A', 'han-dwa-qa' ),
    		'new_item'             => __( 'New Q&A', 'han-dwa-qa' ),
    		'edit_item'            => __( 'Edit Q&A', 'han-dwa-qa' ),
    		'view_item'            => __( 'View Q&A', 'han-dwa-qa' ),
    		'all_items'            => __( "All Q&A's", 'han-dwa-qa' ),
    		'search_items'         => __( "Find Q&A's", 'han-dwa-qa' ),
    		'not_found'            => __( "No Q&A's found", 'han-dwa-qa' ),
    		'not_found_in_trash'   => __( "No Q&A's found in the trash", 'han-dwa-qa' )
        )
    );

    register_post_type( HAN_DWA_QA_CPT, $qaCptArgs );

    // Create the class taxonomy
	$qaClassTaxArgs = array(
		'hierarchical'        => true,
		'show_ui'             => true,
		'show_admin_column'   => true,
		'query_var'           => true,
		'rewrite'             => array(
            'slug' => __( 'class', 'han-dwa-qa' )
        ),
        'labels'              => array(
    	    'name'                => __( 'Classes', 'han-dwa-qa' ),
    		'singular_name'       => __( 'Class', 'han-dwa-qa' ),
    		'search_items'        => __( 'Find classes', 'han-dwa-qa' ),
    		'all_items'           => __( 'All classes', 'han-dwa-qa' ),
            'parent_item'         => __( 'Parent class', 'han-dwa-qa' ),
    		'parent_item_colon'   => __( 'Parent class', 'han-dwa-qa' ) . '.',
    		'edit_item'           => __( 'Edit class', 'han-dwa-qa' ),
    		'update_item'         => __( 'Update class', 'han-dwa-qa' ),
    		'add_new_item'        => __( 'Add new class', 'han-dwa-qa' ),
    		'new_item_name'       => __( 'New class name', 'han-dwa-qa' ),
    		'menu_name'           => __( 'Classes', 'han-dwa-qa' )
    	)
	);

	register_taxonomy( HAN_DWA_QA_CLASS_TAX, array( HAN_DWA_QA_CPT ), $qaClassTaxArgs );

    // Create the questions post type
    $qaCptQuestionArgs = array(
        'public'             => false,
        'show_ui'            => true,
        'has_archive'        => false,
        'hierarchical'       => false,
        'supports'           => array( 'title' ),
        'menu_icon'          => 'dashicons-format-status',
        'labels'             => array(
            'name'                 => __( 'Posted items', 'han-dwa-qa' ),
    		'singular_name'        => __( 'Posted item', 'han-dwa-qa' ),
    		'menu_name'            => __( 'Posted items', 'han-dwa-qa' ),
    		'name_admin_bar'       => __( 'Posted items', 'han-dwa-qa' ),
    		'add_new'              => __( 'Add new item', 'han-dwa-qa' ),
    		'add_new_item'         => __( 'Add new item', 'han-dwa-qa' ),
    		'new_item'             => __( 'New item', 'han-dwa-qa' ),
    		'edit_item'            => __( 'Edit item', 'han-dwa-qa' ),
    		'view_item'            => __( 'View item', 'han-dwa-qa' ),
    		'all_items'            => __( 'All items', 'han-dwa-qa' ),
    		'search_items'         => __( 'Find items', 'han-dwa-qa' ),
    		'not_found'            => __( 'No items found', 'han-dwa-qa' ),
    		'not_found_in_trash'   => __( 'No items found in the trash', 'han-dwa-qa' )
        ),
        'map_meta_cap'      => true,
        'capabilities'      => array(
            'create_posts' => 'han_dwa_qa_create_question'
        )
    );

    register_post_type( HAN_DWA_QA_QUESTION_CPT, $qaCptQuestionArgs );
}

/**
 * Add columns in the admin panel for the questions post type
 * @param (array) the columns
 * @return (array) the modified columns array
 */
function han_dwa_qa_add_question_admin_columns( $columns ) {
    return array(
        'cb'      => '<input type="checkbox" />',
        'title'   => __( 'Title' ),
        'email'   => __( 'Email', 'han-dwa-qa' ),
        'votes'   => __( 'Votes', 'han-dwa-qa' ),
        'qa'      => __( 'Q&A', 'han-dwa-qa' ),
        'date'    => __( 'Date' )
    );
}

/**
 * Add content to the created admin columns for questions
 * @param (string) the column title
 * @param (int) the post ID
 * @return (void)
 */
function han_dwa_qa_question_admin_columns_content( $column, $postId ) {
    $question = new Question( $postId );

    if($column === 'email') {
        echo $question->getEmail();
    }
    elseif($column === 'votes') {
        echo $question->getVotes();
    }
    elseif($column === 'qa') {
        $qa = $question->getQa();

        echo sprintf(
            '<a href="%s">%s</a>',
            esc_url( add_query_arg( array( 'post' => $qa->ID, 'action' => 'edit' ), 'post.php' ) ),
            esc_html( sanitize_term_field( 'name', $qa->post_title, $qa->ID, 'name', 'display' ) )
        );
    }
}

/**
 * Add columns in the admin panel for the Q&A post type
 * @param (array) the columns
 * @return (array) the modified columns array
 */
function han_dwa_qa_add_qa_admin_columns( $columns ) {
    return array(
        'cb'                                 => '<input type="checkbox" />',
        'title'                              => __( 'Title' ),
        'question-counter'                   => __( 'Number of posted items', 'han-dwa-qa' ),
        'taxonomy-' . HAN_DWA_QA_CLASS_TAX   => __( 'Classes', 'han-dwa-qa' ),
        'date'                               => __( 'Date' )
    );
}

/**
 * Add content to the created admin columns for Q&A
 * @param (string) the column title
 * @param (int) the post ID
 * @return (void)
 */
function han_dwa_qa_admin_columns_content( $column, $postId ) {
    if($column === 'question-counter') {
        echo count( han_dwa_qa_get_questions_for_qa( $postId ) );
    }
}