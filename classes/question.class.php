<?php

class Question {
    private $id;
    private $post;
    private $name;
    private $email;
    private $reference;
    private $votes;
    private $qa;

    /**
     * Constructor
     * @param (int) the question ID
     * @return (void)
     */
    public function __construct( $questionId ) {
        $this->id = $questionId;

        self::get_question_post_object();
        if(self::question_exists()) self::set_post_meta();
    }

    /**
     * Get the question object from the database
     * @return (object/null) the post object or null when not existing
     */
    private function get_question_post_object() {
        if(!self::question_exists()) $this->post = get_post( $this->id );
        return $this->post;
    }

    /**
     * Set the post meta
     * @return (void)
     */
    private function set_post_meta() {
        $this->name        = get_post_meta( $this->id, 'han_dwa_qa_question_name', true );
        $this->email       = get_post_meta( $this->id, 'han_dwa_qa_question_email', true );
        $this->reference   = get_post_meta( $this->id, 'han_dwa_qa_question_reference', true );

        self::set_votes_count();
    }

    /**
     * Set votes count
     * @return (void)
     */
    private function set_votes_count() {
        global $wpdb;

        $tableName     = $wpdb->prefix . HAN_DWA_QA_QUESTION_VOTES_TABLE_NAME;
        $this->votes   = $wpdb->get_var( "SELECT COUNT(*) FROM `$tableName` WHERE `question_id` = $this->id" );
    }

    /**
     * Check if the question exists
     * @return (bool) true if existing, false when not
     */
    public function question_exists() {
        return (bool)$this->post;
    }

    /**
     * Get the ID
     * @return (int) the question ID
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get the post
     * @return (object) the post object
     */
    public function getPost() {
        return $this->post;
    }

    /**
     * Get the name
     * @return (string) the name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Get the email
     * @return (string) the email
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Get the reference
     * @return (string) the reference
     */
    public function getReference() {
        return $this->reference;
    }

    /**
     * Get the votes
     * @return (int) the vote count
     */
    public function getVotes() {
        return $this->votes;
    }

    /**
     * Get the Q&A post object for this question
     * @return (object/null) the post object when existing, null when not chained
     */
    public function getQa() {
        global $wpdb;

        if($this->qa === null) {
            $tableName   = $wpdb->prefix . HAN_DWA_QA_QUESTION_RELATION_TABLE_NAME;
            $sql         = "SELECT `qa_id` FROM `$tableName` WHERE `question_id` = '$this->id' LIMIT 1";
            $qaId        = $wpdb->get_var( $sql );
            $this->qa    = get_post( $qaId );
        }

        return $this->qa;
    }
}