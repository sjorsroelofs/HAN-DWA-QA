<?php $questions = han_dwa_qa_get_questions_for_qa( get_the_ID() ); ?>
<hr/>
<div class="han_dwa_qa_asked_questions">
    <h3><?php _e( 'Posted items', 'han-dwa-qa' ); ?></h3>

    <?php if(count( $questions )) : ?>
        <div class="han_dwa_qa_asked_questions_list">
            <?php foreach($questions as $question) : ?>
                <?php require( 'asked_question.php' ); ?>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p><em><?php _e( 'No items have been posted', 'han-dwa-qa' ); ?>.</em></p>
    <?php endif; ?>
</div>