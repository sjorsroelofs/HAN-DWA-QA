<h4><?php _e( 'Name', 'han-dwa-qa' ); ?>:</h4>
<input class="large-text" type="text" name="question-name" value="<?php echo $question->getName(); ?>" />

<h4><?php _e( 'Email', 'han-dwa-qa' ); ?>:</h4>
<input class="large-text" type="email" name="question-email" value="<?php echo $question->getEmail(); ?>" />

<h4><?php _e( 'Reference', 'han-dwa-qa' ); ?>:</h4>
<textarea class="large-text" rows="10" name="question-reference"><?php echo $question->getReference(); ?></textarea>