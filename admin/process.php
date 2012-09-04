<?php require_once('../includes/functions.php') ?>
<?php $action = $_POST['action'] ?>
<?php
switch ($action) {
	case 'add_choice':
				if(isset($_POST['question_index'])) {
					$question_index = $_POST['question_index'];
				}
				if(isset($_POST['choice_index'])) {
					$choice_index = $_POST['choice_index'];
				}
				include('choice.php');
				break;

	case 'add_question':
				if(isset($_POST['question_index'])) {
					$question_index = $_POST['question_index'];
				}
				include('question.php');
				break;
}
?>
