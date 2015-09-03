<div class="han_dwa_qa_asked_question">
    <?php $post = $question->getPost(); ?>
    <p class="meta">
        <span class="dashicons dashicons-thumbs-up upvote" title="<?php _e( 'Upvote this question', 'han-dwa-qa' ); ?>" data-question-id="<?php echo $question->getId(); ?>"></span>&nbsp;
        <strong><?php echo $question->getName(); ?></strong> (<span class="vote-count"><?php echo $question->getVotes(); ?></span> <?php echo _n( 'vote', 'votes', $question->getVotes(), 'han-dwa-qa' ); ?>)<br/>
        <small><em><?php echo sprintf( __( 'Posted on %s at %s', 'han-dwa-qa' ), date( 'd-m-Y', strtotime( $post->post_date )), date( 'H:i', strtotime( $post->post_date ) ) ); ?></em></small>
    </p>
    <p class="comment"><?php echo nl2br( $post->post_content ); ?></p>
    <small class="reference">
        <strong><?php _e( 'References', 'han-dwa-qa' ); ?>:</strong>
        <p><em><?php echo $question->getReference(); ?></em></p>
    </small>
</div>