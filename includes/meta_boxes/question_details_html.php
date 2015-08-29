<h4>Naam:</h4>
<input class="large-text" type="text" name="question-name" value="<?php echo $question->getName(); ?>" />

<h4>Email:</h4>
<input class="large-text" type="email" name="question-email" value="<?php echo $question->getEmail(); ?>" />

<h4>Reference:</h4>
<textarea class="large-text" rows="10" name="question-reference"><?php echo $question->getReference(); ?></textarea>