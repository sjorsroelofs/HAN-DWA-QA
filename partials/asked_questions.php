<?php $questions = han_dwa_qa_get_questions_for_qa( get_the_ID() ); ?>
<hr/>
<div class="han_dwa_qa_asked_questions">
    <h3>Gestelde vragen</h3>

    <?php if(count( $questions )) : ?>
        <div class="han_dwa_qa_asked_questions_list">
            <?php foreach($questions as $question) : ?>
                <?php require( 'asked_question.php' ); ?>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p><em>Er zijn nog geen vragen gesteld.</em></p>
    <?php endif; ?>
</div>