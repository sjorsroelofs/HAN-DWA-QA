<div class="han_dwa_qa_asked_question">
    <?php $post = $question->getPost(); ?>
    <p class="meta">
        <span class="dashicons dashicons-thumbs-up upvote" title="Deze vraag upvoten" data-question-id="<?php echo $question->getId(); ?>"></span>&nbsp;
        <strong><?php echo $question->getName(); ?></strong> (<span class="vote-count"><?php echo $question->getVotes(); ?></span> vote<?php if($question->getVotes() != 1) echo 's'; ?>)<br/>
        <small><em>Geplaatst op <?php echo date( 'd-m-Y', strtotime( $post->post_date ) ); ?> om <?php echo date( 'H:i', strtotime( $post->post_date ) ); ?></em></small>
    </p>
    <p class="comment"><?php echo nl2br( $post->post_content ); ?></p>
    <small class="reference">
        <strong>Referenties:</strong>
        <p><em><?php echo $question->getReference(); ?></em></p>
    </small>
</div>