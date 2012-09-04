<?php ob_start() ?>
<?php session_start(); ?>
<?php require_once("mysql_conf.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php $lang = set_language() ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Splash</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="css/reset.css" rel="stylesheet" type="text/css" />
	<link href="css/uvt.css" rel="stylesheet" type="text/css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="js/script.js"></script>
</head>
<body>

<?php

	if(isset($_POST["submit"])) {
		unset($_POST["submit"]);
		$post_subject_id = $_POST["subject_id"];
		$post_study_id = $_POST["study_id"];
		unset($_POST["subject_id"]);
		unset($_POST["study_id"]);
		
		echo "<pre>";
		var_dump($_POST);
		echo "</pre>";
		//exit;
	
		$response_id = MD5($study_id.$subject_id.time());

		foreach($_POST as $question_id => $choice_id) {
			
			$check = "SELECT * FROM results WHERE study_id = ".$post_study_id." AND subj_id = ".$post_subject_id." AND question_id = ".$question_id;
			$result = mysql_query($check, $dbconnect);
			
			if(mysql_num_rows($result) == 0){
				$questionnaire_id = get_questionnaire_for_question($question_id);
				$query = "INSERT INTO results (`study_id`, `subj_id`, `questionnaire_id`, `question_id`, `choice_id`, `response_id`)
								 VALUES ('".$post_study_id."', '".$post_subject_id."', '".$questionnaire_id."', '".$question_id."', '".$choice_id."', '".$response_id."') ";
				$result = mysql_query($query, $dbconnect);
				confirm_query($result);
			} else {
			}
		}
	   //redirect("admin/view_subject.php?subj_id=".$post_subject_id);
	}


	if(isset($_GET["subj"])) {
		$subject_id = $_GET["subj"];
	} else {
		redirect("index.php");
	}

	if(isset($_GET["study"])) {
		$study_id = $_GET["study"];
	} else {
		redirect("index.php");
	}

	$result = get_quest_for_study($study_id);
	while ($row = mysql_fetch_array($result)) {
		$questionnaire_ids[] = $row["questionnaire_id"];
	}
  ?>


<div id="wrapper">
	
	
<!--<div style="width:200px; height:200px; background:#ccc;">
	<div style="float:left;vertical-align:middle; background:#FB0000; width:50%; height:50px;">
		<input style="margin:0; padding:0" type="radio" name="pic" value="1"/>
	</div>
</div>
-->

	

	<div id="main_content">
		<p class="title">Prescriptive Index</p>

		<div id="list_details" style="margin-top:30px;">
			<form id="" action="fill.php" method="post">
				<input type="hidden" name="subject_id" value="<?php echo $subject_id ?>" />
				<input type="hidden" name="study_id" value="<?php echo $study_id ?>" />
			 
				<?php
					foreach($questionnaire_ids as $questionnaire_id) :
					
						$result = get_questionnaire($questionnaire_id);
						$row = mysql_fetch_array($result);
							$questionnaire_id = $row["questionnaire_id"];
							$questionnaire_name = decode($row["name"], $lang);
							$questionnaire_desc = decode($row["desc"], $lang);
							$display_type = $row["display_type"];
							$quest_type = $row["quest_type"];
							$max_score = $row["max_score"];
							$result = get_questions_for_questionnaire($questionnaire_id);
							$question_count = mysql_num_rows($result);
				?>
						<h2><strong><?php echo $questionnaire_name ?></strong></h2>
						<div class="desc" style="margin-bottom:20px;">
							<?php echo nl2br($questionnaire_desc, false) ?>
						</div>


						
						<?php if ($display_type == "normal"): ?>
						<div class="questionnaire">
							<ul>
								<?php
								while ($row = mysql_fetch_array($result)) {
									$question_id = $row["question_id"];
									$question_name = decode($row["name"], $lang);
								?>
								<li>
									<p><strong><em><?php echo html_entity_decode($question_name) ?></em></strong></p>
									<?php
										$result_choice = get_choices_for_question($question_id);
										while ($row = mysql_fetch_array($result_choice)) {
											$choice_name = decode($row["name"], $lang);
											$choice_score = $row["score"];
											if (empty($choice_name) || $choice_name == '-')
												continue;
									?>
									<input type="radio" name="<?php echo $question_id ?>" value="<?php echo $choice_score ?>" />&nbsp;<?php echo $choice_name ?><br />
									<?php
										}
									?>
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
			
		
		" name="<?php echo $question_id ?>" value="<?php echo $choice_score ?>" />
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