<h4><?php _e( 'Name', 'han-dwa-qa' ); ?>:</h4>
<input class="large-text" type="text" name="question-name" value="<?php echo $question->getName(); ?>" />

<h4><?php _e( 'Email', 'han-dwa-qa' ); ?>:</h4>
<input class="large-text" type="email" name="question-email" value="<?php echo $question->getEmail(); ?>" />

<?php for($i = 0; $i < count( $questions ); $i++) : ?>
    <br/><br/><hr/>
    
    <h4><?php _e( 'Question', 'han-dwa-qa' ); ?> <?php echo $i + 1; ?>:</h4>
    <textarea class="large-text" rows="6" name="question-<?php echo $i + 1; ?>"><?php echo $questions[$i]; ?></textarea>

    <h4><?php _e( 'Reference', 'han-dwa-qa' ); ?> <?php echo $i + 1; ?>:</h4>
    <textarea class="large-text" rows="3" name="reference-<?php echo $i + 1; ?>"><?php echo $references[$i]; ?></textarea>
<?php endfor; ?>