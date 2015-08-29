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
            'name'                 => 'Q&A\'s',
    		'singular_name'        => 'Q&A',
    		'menu_name'            => 'Q&A\'s',
    		'name_admin_bar'       => 'Q&A',
    		'add_new'              => 'Nieuwe Q&A toevoegen',
    		'add_new_item'         => 'Nieuwe Q&A toevoegen',
    		'new_item'             => 'Nieuwe Q&A',
    		'edit_item'            => 'Bewerk Q&A',
    		'view_item'            => 'Bekijk Q&A',
    		'all_items'            => 'Alle Q&A\'s',
    		'search_items'         => 'Zoek Q&A\'s',
    		'not_found'            => 'Geen Q&A\'s gevonden',
    		'not_found_in_trash'   => 'Geen Q&A\'s gevonden in de prullenbak'
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
            'slug' => 'klas'
        ),
        'labels'              => array(
    	    'name'                => 'Klassen',
    		'singular_name'       => 'Klas',
    		'search_items'        => 'Zoek klassen',
    		'all_items'           => 'Alle klassen',
            'parent_item'         => 'Bovenliggende klas',
    		'parent_item_colon'   => 'Bovenliggende klas:',
    		'edit_item'           => 'Bewerk klas',
    		'update_item'         => 'Update klas',
    		'add_new_item'        => 'Nieuwe klas toevoegen',
    		'new_item_name'       => 'Naam nieuwe klas',
    		'menu_name'           => 'Klassen'
    	)
	);

	register_taxonomy( HAN_DWA_QA_CLASS_TAX, array( HAN_DWA_QA_CPT ), $qaClassTaxArgs );

    // Create the questions post type
    $qaCptQuestionArgs = array(
        'public'             => false,
        'show_ui'            => true,
        'has_archive'        => false,
        'hierarchical'       => false,
        'supports'           => array( 'editor' ),
        'menu_icon'          => 'dashicons-format-status',
        'labels'             => array(
            'name'                 => 'Gestelde vragen',
    		'singular_name'        => 'Gestelde vraag',
    		'menu_name'            => 'Gestelde vragen',
    		'name_admin_bar'       => 'Gestelde vraag',
    		'add_new'              => 'Nieuwe vraag toevoegen',
    		'add_new_item'         => 'Nieuwe vraag toevoegen',
    		'new_item'             => 'Nieuwe vraag',
    		'edit_item'            => 'Bewerk vraag',
    		'view_item'            => 'Bekijk vraag',
    		'all_items'            => 'Alle vragen',
    		'search_items'         => 'Zoek vragen',
    		'not_found'            => 'Geen vragen gevonden',
    		'not_found_in_trash'   => 'Geen vragen gevonden in de prullenbak'
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
        'email'   => 'Email',
        'votes'   => 'Votes',
        'qa'      => 'Q&A',
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
        'question-counter'                   => 'Aantal gestelde vragen',
        'taxonomy-' . HAN_DWA_QA_CLASS_TAX   => 'Klassen',
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