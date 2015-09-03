<div id="han_dwa_qa_new_question_form_wrapper">
    <br/>
    <h3 class="comment-reply-title"><?php _e( 'Submit your question', 'han-dwa-qa' ); ?></h3>

    <form class="comment-form" data-qa-id="<?php echo get_the_ID(); ?>">
        <br/>
        <p>
            <label for="name"><?php _e( 'Name', 'han-dwa-qa' ); ?> <span class="required">*</span></label>
            <input id="name" name="name" type="text" value="" aria-required="true" required="required" />
        </p>
        <p>
            <label for="email"><?php echo _e( 'Email', 'han-dwa-qa' ); ?> <span class="required">*</span></label>
            <input id="email" name="email" type="email" value="" aria-required="true" required="required" />
        </p>
        <?php for($i = 1; $i <= han_dwa_qa_get_qa_question_amount( get_the_ID() ); $i++) : ?>
            <p>
                <label for="question-<?php echo $i; ?>"><?php echo sprintf( __( 'Your question or discussion item %s', 'han-dwa-qa' ), $i ); ?> <span class="required">*</span></label>
                <textarea id="question-<?php echo $i; ?>" name="question_<?php echo $i; ?>" cols="45" rows="4" aria-required="true" required="required"></textarea>
            </p>
            <p>
                <label for="reference"><?php echo sprintf( __( 'Your references (including quote, url, time in video) for question %s', 'han-dwa-qa' ), $i ); ?> <span class="required">*</span></label>
                <textarea id="reference" name="reference_<?php echo $i; ?>" cols="45" rows="2" aria-required="true" required="required"></textarea>
            </p>
        <?php endfor; ?>

        <p class="form-submit">
            <input name="submit" type="submit" id="submit" class="submit" value="<?php _e( 'Submit', 'han-dwa-qa' ); ?>" />
        </p>
    </form>
</div>