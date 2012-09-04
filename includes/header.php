<?php require_once("init.php") ?>
<?php $lang = set_language() ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>UV-TM</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="description" />
	<meta name="keywords" content="keywords" />
	<link rel="shortcut icon" href="../images/favicon.ico" />
	<link href="../css/reset.css" rel="stylesheet" type="text/css" />
	<link href="../css/uvt.css" rel="stylesheet" type="text/css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="../js/script.js"></script>
	<script src="../js/ajax.script.js"></script>

</head>
<body>
	<div id="wrapper">
		
		<!--<div id="header">-->
		<div id="header">
			<div id="lang">
				<a title="English" href="<?php echo get_url() ?>?lang=en">
					<img class="lang-icon" alt="English" src="../images/en.gif">
				</a>
				<a title="Română" href="<?php echo get_url() ?>?lang=ro">
					<img class="lang-icon" alt="Română" src="../images/ro.gif">
				</a>
			</div>

			<img id="logo" src="../images/uvt_logo.png" alt="" />

		</div>

		<div id="main_content">
			<div id="top_nav">
				<ul class="menu">
					<li><a href="manage_lists.php"><?php __("List management") ?></a></li>
					<li><a href="manage_subjects.php"><?php __("Subjects management") ?></a></li>
					<li><a href="manage_questionnaires.php"><?php __("Questionnaire management") ?></a></li>
					<li><a href="manage_studies.php"><?php __("Study management") ?></a></li>
					<li><a href="manage_emails.php"><?php __("Email management") ?></a></li>
				</ul>
			</div>