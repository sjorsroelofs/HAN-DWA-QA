<h4><?php _e( 'Amount of questions', 'han-dwa-qa' ); ?></h4>
<select name="question-amount">
    <?php for($i = 1; $i <= 5; $i++) : ?>
        <option value="<?php echo $i; ?>"<?php if($quesitonAmount == $i) echo ' selected="selected"'; ?>><?php echo $i; ?></option>
    <?php endfor; ?>
</select>