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
	<div id="main_content">
		<p class="title">Prescriptive Index</p>
		<div id="list_details" style="margin-top:30px;">

<?php
	if(isset($_POST["submit"])) {
		unset($_POST["submit"]);
		$subject_id = $_POST["subject_id"];
		if(isset($_POST["sub_evaluat"])) {
			$rel_subject_id = $_POST["sub_evaluat"];
			unset($_POST["sub_evaluat"]);
		}
		if(isset($_POST["relatie_sub_evaluat"])) {
			$relatie = $_POST["relatie_sub_evaluat"];
			unset($_POST["relatie_sub_evaluat"]);
		}

		$study_id = $_POST["study_id"];
		unset($_POST["subject_id"]);
		unset($_POST["study_id"]);

		$result = get_study($study_id);
		$row = mysql_fetch_array($result);
		$study_type = $row["study_type"];

#		echo "<pre>";
#		var_dump($_POST);
		//die('gata');
		
		$tester = subject_completed_study($subject_id, $study_id);
		
		if($tester == true) {
			?>
				<p><?php __('You have already completed this study.') ?></p>
				<a href="index.php"><?php __('Back') ?></a>
			<?php
			die;
		}
		
		$response_id = MD5($study_id.$subject_id.time());

		foreach($_POST as $question_id => $answer) {
			
			$question_type = get_question_type($question_id);
			$check = "SELECT * FROM results
			WHERE study_id = ".$study_id." AND subj_id = ".$subject_id." AND question_id = ".$question_id." AND response_id = '".$response_id."'";
#			echo $check;
			$result = mysql_query($check, $dbconnect);
			
			if(mysql_num_rows($result) == 0){

				$questionnaire_id = get_questionnaire_for_question($question_id);
				
				if($question_type == 'choice') {
					$choice_name = get_choice_name($answer, 'ro');
					$query = "INSERT INTO results (`study_id`, `subj_id`, `questionnaire_id`, `question_id`, `choice_id`, `data`, `response_id`)
								VALUES ('".$study_id."', '".$subject_id."', '".$questionnaire_id."', '".$question_id."', '".$answer."', '".$choice_name."' , '".$response_id."') ";
					$result = mysql_query($query, $dbconnect);
					confirm_query($result);

				} elseif($question_type == 'text') {
					$query = "INSERT INTO results (`study_id`, `subj_id`, `questionnaire_id`, `question_id`, `data`, `response_id`)
									VALUES ('".$study_id."', '".$subject_id."', '".$questionnaire_id."', '".$question_id."', '".mysql_real_escape_string(htmlspecialchars($answer))."', '".$response_id."') ";
					$result = mysql_query($query, $dbconnect);
					confirm_query($result);
				}
			}
		}
		
		if($study_type == '360') {
			$query = "INSERT IGNORE INTO multievaluator	(`subj_id`, `rel_subj_id`, `relation`, `study_id`, `response_id`) 
														VALUES	('".$subject_id."', '".$rel_subject_id."', '".$relatie."', '".$study_id."', '".$response_id."')";
			$result = mysql_query($query, $dbconnect);
			confirm_query($result);
			$query_string = base64_encode(implode(',', array($study_id, $subject_id)));
			
			redirect("fill.php?data=".$query_string);
		}
		
		

		?>
		<p><strong><?php __('Responses have been saved.') ?></strong></p>
		<p><em><?php __('Thank you for participating.') ?></em></p>
		<a href="index.php"><?php __('Back') ?></a>
		<?php
		die();
	}
?>

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