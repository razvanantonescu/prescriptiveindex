<?php ob_start() ?>
<?php session_start(); ?>
<?php require_once("mysql_conf.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php $lang = set_language() ?>

<?php
	$subject_id = 1;

	if(isset($_POST["study_id"])) {
		$study_id = $_POST["study_id"];
	}

   $result = get_study($study_id);
   $row = mysql_fetch_array($result);
		$study_name = decode($row["name"], $lang);
		$study_desc = decode($row["desc"], $lang);


	$result = get_quest_for_study($study_id);
	while ($row = mysql_fetch_array($result)) {
		$questionnaire_ids[] = $row["questionnaire_id"];
	}
?>

			<form id="" action="tester_fill.php" method="post">
				<input type="hidden" name="subject_id" value="<?php echo $subject_id ?>" />
				<input type="hidden" name="study_id" value="<?php echo $study_id ?>" />
				
				<h2><?php echo $study_name ?></h2>
				<p><strong><?php __('Description') ?>: </strong><?php echo $study_desc ?></p>
			 
				<?php
					foreach($questionnaire_ids as $questionnaire_id) :
					
						$result = get_questionnaire($questionnaire_id);
						$row = mysql_fetch_array($result);
							$questionnaire_id = $row['questionnaire_id'];
							$questionnaire_name = decode($row['name'], $lang);
							$questionnaire_desc = decode($row['desc'], $lang);
							$display_type = $row['display_type'];
							$quest_type = $row['quest_type'];
							$max_score = $row['max_score'];
							$result = get_questions_for_questionnaire($questionnaire_id);
							$question_count = mysql_num_rows($result);
				?>
						<h3><strong><?php echo $questionnaire_name ?></strong></h3>
						<div class="desc" style="margin-bottom:20px;">
							<?php echo nl2br($questionnaire_desc, false) ?>
						</div>

						<?php if ($display_type == 'normal'): ?>
						<div class="questionnaire">
							<ul class="question fill">
								<?php
								while ($row = mysql_fetch_array($result)) {
									$question_id = $row['question_id'];
									$question_type = $row['type'];
									$question_name = decode($row['name'], $lang);
								?>
								<li>
									<p><strong><em><?php echo html_entity_decode($question_name) ?></em></strong></p>
									<ul class="answer fill">
									<?php
										if($question_type == 'choice') {
											$result_choice = get_choices_for_question($question_id);
											while ($row = mysql_fetch_array($result_choice)) {
												$choice_name = decode($row['name'], $lang);
												//$choice_score = $row['score'];
												$choice_id = $row['choice_id'];
												if (empty($choice_name) || $choice_name == '-') {
													continue;
												} else {
													echo '<li><input type="radio" name="'.$question_id.'" value="'.$choice_id.'" /><span class="text">'.$choice_name.'</span></li>';
												}
											}
										} elseif ($question_type == 'text') {
											echo '<li><input type="text" name="'.$question_id.'" /></li>';
										}
									?>
									</ul>
								</li>
								<?php
								}
								?>
							</ul>
						<?php endif; ?>

						<?php if ($display_type == "radial"): ?>
						<div class="questionnaire" style="background:#F3F3F3; position:relative; height:800px;">
						<?php
							$xoffset=425;
							$yoffset=405;
							$steps = array(120, 150, 180, 220, 270, "label" => 350);
							$angle_radius = round(360/$question_count, 2);
							$angle = 0;
							$y_sprite=0;

							while ($row = mysql_fetch_array($result)) :
							
								$question_id = $row["question_id"];
								$question_name = decode($row["name"], $lang);
								$result_choice = get_choices_for_question($question_id);
								$choice_row = mysql_fetch_array($result_choice);

								$x = $xoffset + round(cos(($angle+90+$angle_radius/2) * M_PI / 180) * $steps["label"]);
								$y = $yoffset + round(sin(($angle+90+$angle_radius/2) * M_PI / 180) * $steps["label"]);
						?>
							<div class="label" style="position:absolute; left:<?php echo $x-40 ?>px; top:<?php echo $y ?>px; width:80px;"><?php echo $question_name ?></div>
						<?php
								$i = 0;
								$x_sprite=0;

	$result_choice = get_choices_for_question($question_id);
	while ($row = mysql_fetch_array($result_choice)):
		$choice_name = decode($row["name"], $lang);
		$choice_score = $row["score"];
		$choice_id = $row["choice_id"];
		$x = $xoffset + round(cos(($angle+90+$angle_radius/2) * M_PI / 180) * $steps[$i]);
		$y = $yoffset + round(sin(($angle+90+$angle_radius/2) * M_PI / 180) * $steps[$i]);
		$size = 20+5*$i;
	?>
		<div style="
			align:center; position:absolute; height:<?php echo $size ?>px; width:<?php echo $size ?>px;

			left:<?php echo $x - $size/2 ?>px;
			top:<?php echo $y - $size/2 ?>px;

			/*background-color:#FB0000; */	
			background-image:url(images/sprite.png);
			background-position:<?php echo $x_sprite ?>px <?php echo -1 * (1240 - (-1) * $y_sprite) ?>px;
			background-repeat:no-repeat;
			
		">
		<input type="radio" style="
			position:relative;
			top:<?php echo 3 + 5*$i/2 ?>px;
			left:<?php echo 3 + 5*$i/2 ?>px;
			
		
		" name="<?php echo $question_id ?>" value="<?php echo $choice_id ?>" />
		</div>
	<?php
	$x_sprite = $x_sprite - 20 - 5*$i;
	$i++;

	endwhile;
$y_sprite = $y_sprite - 40;

$angle = $angle + $angle_radius;
endwhile;
?>

<?php endif; //end if display type = radial ?> 
</div>
	
				<?php
					endforeach;
				?>  
	
				
			<div class="clear">
				<input name="submit" type="submit" value="<?php __("Send") ?> &raquo;" class="buton"/>
			</div>      
			</form>