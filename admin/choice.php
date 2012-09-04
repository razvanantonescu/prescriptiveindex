<?php require_once("../mysql_conf.php"); ?>
<div class="choice item" id="question_<?php echo $question_index ?>_choice_<?php echo $choice_index ?>">
	<fieldset class="title">
		<div class="ro">
			<label for="question_<?php echo $question_index ?>_choice_<?php echo $choice_index ?>_ro"><?php __("Choice") ?><span class="number"><?=$choice_index?></span></label>
			<input class="required" name="question_<?php echo $question_index ?>_choice_<?php echo $choice_index ?>_ro" type="text" value="" />
		</div>
		<div class="en">
			<label for="question_<?php echo $question_index ?>_choice_<?php echo $choice_index ?>_en">Choice (en) <span class="number"><?=$choice_index?></span></label>
			<input class="required" name="question_<?php echo $question_index ?>_choice_<?php echo $choice_index ?>_en" type="text" value="" />
		</div>
	</fieldset>
	<fieldset class="inline score">
		<label class="clear" for="question_<?php echo $question_index ?>_choice_<?php echo $choice_index ?>_score">Score</label>
		<input class="required" class="inline" name="question_<?php echo $question_index ?>_choice_<?php echo $choice_index ?>_score" type="text" value="" />
	</fieldset>
</div>
