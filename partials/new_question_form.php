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
        <p>
            <label for="question"><?php _e( 'Your question, discussion item', 'han-dwa-qa' ); ?> <span class="required">*</span></label>
            <textarea id="question" name="question" cols="45" rows="6" aria-required="true" required="required"></textarea>
        </p>
        <p>
            <label for="question"><?php _e( 'Your references (including quote, url, time in video)', 'han-dwa-qa' ); ?> <span class="required">*</span></label>
            <textarea id="reference" name="reference" cols="45" rows="4" aria-required="true" required="required"></textarea>
        </p>
        <p class="form-submit">
            <input name="submit" type="submit" id="submit" class="submit" value="<?php _e( 'Submit', 'han-dwa-qa' ); ?>" />
        </p>
    </form>
</div>