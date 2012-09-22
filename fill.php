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

<?php

	
	// procesare chestionare trimise

	if(isset($_POST["submit"])) {
		unset($_POST["submit"]);
		$subject_id = $_POST["subject_id"];
		$study_id = $_POST["study_id"];
		unset($_POST["subject_id"]);
		unset($_POST["study_id"]);
		
		$tester = subject_completed_study($subject_id, $study_id);
		
		if($tester == true) {
			?>
				<p>Ai completat deja acest studiu</p>
				<a href="index.php">Inapoi</a>
			<?php
			die;
		}
		
		$response_id = MD5($study_id.$subject_id.time());
//		$csv_output = fopen('csv/'.$response_id.'.csv', 'w'));

			$data = array();

			$data['subj_id']				= 'subj_id';
			$data['response_id'] 		= 'response_id';
			$data['study_id']				= 'study_id';
			$data['questionnaire_id'] 	= 'questionnaire_id';
			$data['question_id'] 		= 'question_id';
			$data['question_name'] 		= 'question_name';
			$data['question_type']		= 'question_type';
			$data['choice_id'] 			= 'choice_id';
			$data['score'] 				= 'score';
			$data['data'] 					= 'data';
//			fputcsv($csv_output, $data);

		foreach($_POST as $question_id => $answer) {
			
			$data = array();
			$question_type = get_question_type($question_id);
			$check = "SELECT * FROM results WHERE study_id = ".$study_id." AND subj_id = ".$subject_id." AND question_id = ".$question_id;
			$result = mysql_query($check, $dbconnect);
			
			if(mysql_num_rows($result) == 0){

				$questionnaire_id = get_questionnaire_for_question($question_id);
				
				$data['subj_id']				= $subject_id;
				$data['response_id'] 		= $response_id;
				$data['study_id']				= $study_id;
				$data['questionnaire_id'] 	= $questionnaire_id;
				$data['question_id'] 		= $question_id;
				$data['question_name'] 		= get_question_name($question_id, 'ro');
				$data['question_type']		= $question_type;
				$data['choice_id'] 			= null;
				$data['score'] 				= null;
				$data['data'] 					= null;
				
				if($question_type == 'choice') {
					
					$choice_name = get_choice_name($answer, 'ro');
				
					$query = "INSERT INTO results (`study_id`, `subj_id`, `questionnaire_id`, `question_id`, `choice_id`, `data`, `response_id`)
								VALUES ('".$study_id."', '".$subject_id."', '".$questionnaire_id."', '".$question_id."', '".$answer."', '".$choice_name."' , '".$response_id."') ";
					$result = mysql_query($query, $dbconnect);
					confirm_query($result);
					$data['choice_id'] = $answer;
					$data['score'] = get_choice_score($answer);
			} elseif($question_type == 'text') {
					$query = "INSERT INTO results (`study_id`, `subj_id`, `questionnaire_id`, `question_id`, `data`, `response_id`)
									VALUES ('".$study_id."', '".$subject_id."', '".$questionnaire_id."', '".$question_id."', '".mysql_real_escape_string(htmlspecialchars($answer))."', '".$response_id."') ";
					$result = mysql_query($query, $dbconnect);
					confirm_query($result);
					$data['data'] = $answer;
				}

//				fputcsv($csv_output, $data);
			}
		}
		?>
		<p><strong>Raspunsurile au fost salvate!</strong></p>
		<p><em>Multumim pentru participare.</em></p>
		
		<p>Inapoi la <a href="index.php">prescriptiveindex.ro</a>
		<?php
//		fclose($csv_output);
		die();
	}
?>

<!--/////////////////////////////////////////////////////////-->

<?php
	if(isset($_GET['data'])) {
		$data = explode(',', base64_decode($_GET['data']));
		$subject_id = $data[1];
		$study_id = $data[0];
	} else {
		redirect("index.php");
	}


	$tester = subject_completed_study($subject_id, $study_id);
	
	if($tester == true) {
		?>
			<p>Ai completat deja acest studiu</p>
			<a href="index.php">Prescriptive Index</a>
		<?php
		die;
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

<div id="wrapper">
	
	<div id="main_content">
		<p class="title">Prescriptive Index</p>

		<div id="list_details" style="margin-top:30px;">
			<form id="fill" action="fill.php" method="post">
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
		</div>


	</div>
	<div id="footer">
		<div id="bottom_nav">
			<a href="admin">admin</a>
		</div>
		<div id="copyright">&copy; 2012 UVT</div>
	</div>
</div>
</body>
</html>