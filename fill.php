<?php ob_start() ?>
<?php session_start(); ?>
<?php require_once("mysql_conf.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php $lang = set_language() ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Prescriptive Index</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="css/reset.css" rel="stylesheet" type="text/css" />
	<link href="css/uvt.css" rel="stylesheet" type="text/css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="js/script.js"></script>
</head>
<body>
<div id="wrapper">


<style>
	.questionnaire_unit {display:none;}
</style>
	
	  <div id="lang">
		<a title="English" href="<?php echo $_SERVER['PHP_SELF'] ?>?data=<?php echo $_GET['data'] ?>&lang=en">
			<img class="lang-icon" alt="English" src="../images/en.gif">
		</a>
		<a title="Romana" href="<?php echo $_SERVER['PHP_SELF'] ?>?data=<?php echo $_GET['data'] ?>&lang=ro">
			 <img class="lang-icon" alt="Romana" src="../images/ro.gif">
		  </a>
	  </div>
	<div id="main_content">
		<p class="title">Prescriptive Index</p>

		<div id="list_details" style="margin-top:30px;">

<?php
	if(!empty($_GET['data'])) {
		$data = explode(',', base64_decode($_GET['data']));
		$subject_id = $data[1];
		$study_id = $data[0];
	} else {
		redirect("index.php");
	}

	$tester = subject_completed_study($subject_id, $study_id);
	
	if($tester == true) {
		?>
			<p><?php __('You have already completed this study.') ?></p>
			<a href="index.php"><?php __('Back') ?></a>
		<?php
		die;
	}
	
   $result = get_study($study_id);
   $row = mysql_fetch_array($result);
		$study_name = decode($row["name"], $lang);
		$study_desc = decode($row["desc"], $lang);
		$study_type = $row["study_type"];


	$result = get_quest_for_study($study_id);
	while ($row = mysql_fetch_array($result)) {
		$questionnaire_ids[] = $row["questionnaire_id"];
	}
  ?>

			<form id="fill" action="process.php" method="post">
				<input type="hidden" name="subject_id" value="<?php echo $subject_id ?>" />
				<input type="hidden" name="study_id" value="<?php echo $study_id ?>" />
				
				<h2><?php echo $study_name ?></h2>

				<div class="desc" style="margin-bottom:20px;">
					<?php echo nl2br($study_desc, false) ?>
				</div>

				<?php
					if($study_type == '360') :
				?>
				<ul class="studiu_360">
					<li>
						<?php
					
						$liste = get_list_for_study($study_id);
						while($lista = mysql_fetch_array($liste)) {
							$subjects = get_subj_for_list($lista['list_id']);
							while($subject = mysql_fetch_array($subjects)) {
								$sel_subjects[] = $subject['subj_id'];
							}
						}
					
						$sel_subjects = array_unique($sel_subjects);
						$sub_neevaluati = array();
					
						foreach($sel_subjects as $rel_subject_id) {
						$query = "SELECT rel_subj_id FROM multievaluator
									WHERE `subj_id` = '".$subject_id."' AND `rel_subj_id` = '".$rel_subject_id."' AND `study_id` = '".$study_id."'";
									
							$tester = mysql_query($query, $dbconnect);
							//
							if(mysql_numrows($tester) == 0) {
								$subj = mysql_fetch_array($tester);
								$sub_neevaluati[] = $rel_subject_id;
							}
						}
						
						if(count($sub_neevaluati) != 0) {
							?>
						<p><strong><em><?php __('Person being evaluated.') ?></em></strong></p>
							<select name="sub_evaluat">
							<?php
							
							foreach($sub_neevaluati as $subj_id) {
								$subject_name = get_subj_name($subj_id) . "<br />";
								?>
									<option value="<?php echo $subj_id ?>"><?php echo $subject_name ?></option>
								<?php
							}
							?>
							</select>
							<?php
						} else {
							?>
								<p><?php __('You have already completed this study') ?></p>
								<a href="index.php"><?php __('Back') ?></a>
							<?php
								die;
						}
						?>
						
					</li>
					<li>
						<p><strong><em><?php __('Relationship with the person being evaluated.') ?></em></strong></p>
					<?php
					$relatii = array(
											'ro' => array(
																1 => 'subordonat',
																2 => 'manager',
																3 => 'egal',
																4 => 'sine însuşi',
																5 => 'client'
															),
											'en' => array(
																1 => 'subordinate',
																2 => 'manager',
																3 => 'peer',
																4 => 'self',
																5 => 'client'
															)


								);
					?>
						<select name="relatie_sub_evaluat">
							<?php
							foreach($relatii[$lang] as $value => $name) {
								?>
									<option value="<?php echo $value ?>"><?php echo $name ?></option>
								<?php
							}
							?>
						</select>
							
					</li>
				</ul>
				
				<?php
					endif; // studiu 360
				?>

				<?php
					$questionnaire_index = 0;
					$number_of_questionnaires = count($questionnaire_ids);
					foreach($questionnaire_ids as $questionnaire_id) :
					
						$questionnaire_index++;
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
						<div class="questionnaire_unit quest_<?php echo $questionnaire_index ?>">
						<h3><strong><?php echo $questionnaire_name ?></strong></h3>
						<?php //echo $quest_type ?>
						<div class="desc" style="margin-bottom:20px;">
							<?php echo nl2br($questionnaire_desc, false) ?>
						</div>

<!-- display normal -->
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
												$choice_id = $row['choice_id'];
												if (empty($choice_name) || $choice_name == '-') {
													continue;
												} else {
													echo '<li><input type="radio" class="required" name="'.$question_id.'" value="'.$choice_id.'" /><span class="text">'.$choice_name.'</span></li>';
												}
											}
										} elseif ($question_type == 'text') {
											echo '<li><input class="required" type="text" name="'.$question_id.'" /></li>';
										}
									?>
									</ul>
								</li>
								<?php
								}
								?>
							</ul>
						<?php endif; ?>

<!-- display radial -->

						<?php
						
							if ($display_type == "radial"): ?>
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
										background-image:url(images/sprite.png);
										background-position:<?php echo $x_sprite ?>px <?php echo -1 * (1240 - (-1) * $y_sprite) ?>px;
										background-repeat:no-repeat;
									">
										<input type="radio" class="required" style="
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
							endif; //end if display type = radial
						?> 
						</div>

							
							<?php
								if($questionnaire_index != $number_of_questionnaires) {
							?>
							<a href="mai_departe" onclick="validator(this, <?php echo $questionnaire_index ?>); return false;">mai departe</a>
							<?php
								} else {
							?>

							<div class="clear">
								<input name="submit" type="submit" value="<?php __("Send") ?> &raquo;" class="buton"/>
							</div>   

							<?php
								}
							?>
						</div><!-- questionnare_unit -->
	
				<?php
					endforeach;
				?>
	
			</form>
		</div>
	</div>
	<div id="footer">
		<div id="bottom_nav">
			<a href="admin">admin</a>
		</div>
		<div id="copyright">&copy; 2012 UVT</div>
	</div>
</div>

<script>
$('.questionnaire_unit.quest_1').show();
</script>

</body>
</html>