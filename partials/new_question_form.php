<div id="han_dwa_qa_new_question_form_wrapper">
    <br/>
    <h3 class="comment-reply-title">Plaats je vraag</h3>

    <form class="comment-form" data-qa-id="<?php echo get_the_ID(); ?>">
        <br/>
        <p>
            <label for="name">Naam <span class="required">*</span></label>
            <input id="name" name="name" type="text" value="" aria-required="true" required="required" />
        </p>
        <p>
            <label for="email">E-mailadres <span class="required">*</span></label>
            <input id="email" name="email" type="email" value="" aria-required="true" required="required" />
        </p>
        <p>
            <label for="question">Je vraag/vragen <span class="required">*</span></label>
            <textarea id="question" name="question" cols="45" rows="6" aria-required="true" required="required"></textarea>
        </p>
        <p>
            <label for="question">Je referentie(s) <span class="required">*</span></label>
            <textarea id="reference" name="reference" cols="45" rows="4" aria-required="true" required="required"></textarea>
        </p>
        <p class="form-submit">
            <input name="submit" type="submit" id="submit" class="submit" value="Vraag plaatsen" />
            <input type="hidden" name="comment_parent" id="comment_parent" value="0" />
        </p>
    </form>
</div>