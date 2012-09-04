<?php require_once("../mysql_conf.php"); ?>

<div id="question_<?php echo $question_index ?>" class="question item">
	<h3><?php __("Question no.") ?> <span class="number"><?php echo $question_index ?></span></h3>
	<fieldset class="title">
			<div class="ro">
					<label for="question_<?php echo $question_index ?>_ro"><?php __("Question (ro)") ?></label>
					<input class="required" name="question_<?php echo $question_index ?>_ro" type="text" value="" />
			</div>
			<div class="en">
					<label for="question_<?php echo $question_index ?>_en"><?php __("Question (en)") ?></label>
					<input class="required" name="question_<?php echo $question_index ?>_en" type="text" value="" />
			</div>
	</fieldset>

	<select name="question_<?php echo $question_index ?>_type" onchange="toggle_question_type(this)" >
		<option value="text"><?php __('text field') ?></option>
		<option value="choice"><?php __('choice') ?></option>
	</select>

	<div class="choice"></div>
	
	<div class="controls" style="display:none;">
		<a class="add_choice"		href="add_choice"		onclick="add_choice(this);		return false;">[ + ] <?php __("Add answer choice ") ?></a>
		<br />
		<a class="delete_choice" href="delete_choice"	onclick="delete_choice(this);	return false;">[ + ] <?php __("Remove choice ") ?></a>
		<input type="hidden" name="number_of_choices_q<?php echo $question_index ?>" value="0">
	</div>

</div>