<div class="han_dwa_qa_asked_question">
    <?php $post = $question->getPost(); ?>
    <p class="meta">
        <span class="dashicons dashicons-thumbs-up upvote" title="<?php _e( 'Upvote this question', 'han-dwa-qa' ); ?>" data-question-id="<?php echo $question->getId(); ?>"></span>&nbsp;
        <strong><?php echo $question->getName(); ?></strong> (<span class="vote-count"><?php echo $question->getVotes(); ?></span> <?php echo ngettext( __( 'vote', 'han-dwa-qa' ), __( 'votes', 'han-dwa-qa' ), $question->getVotes() ); ?>)<br/>
        <small><em><?php echo sprintf( __( 'Posted on %s at %s', 'han-dwa-qa' ), date( 'd-m-Y', strtotime( $post->post_date )), date( 'H:i', strtotime( $post->post_date ) ) ); ?></em></small>
    </p>

    <?php

    $questions    = $question->getQuestions();
    $references   = $question->getReferences();

    ?>

    <?php for($i = 0; $i < count( $questions ); $i++) : ?>
        <div class="han_dwa_qa_asked_question_single_question">
            <p class="comment">
                <strong><?php echo sprintf( __( 'Question %s', 'han-dwa-qa' ), $i + 1 ); ?></strong><br/>
                <?php echo nl2br( $questions[$i] ); ?>
            </p>

            <small class="reference">
                <strong><?php echo sprintf( __( 'References for question %s', 'han-dwa-qa' ), $i + 1 ); ?>:</strong>
                <p><em><?php echo $references[$i] ?></em></p>
            </small>
        </div>
    <?php endfor; ?>
</div>