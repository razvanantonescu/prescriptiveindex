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
	<?php //function __($text){echo $text;} ?>
</head>
<body>


<?php

if(isset($_POST["submit"])){

	if(isset($_POST["subj_first_name"])) {
		$subj_first_name = mysql_real_escape_string(htmlspecialchars($_POST["subj_first_name"]));
	}
	if(isset($_POST["subj_last_name"])){
		$subj_last_name = mysql_real_escape_string(htmlspecialchars($_POST["subj_last_name"]));
	}

	if(isset($_POST["subj_gender"])) {
		$subj_gender = $_POST["subj_gender"];
	}

	if (isset($_POST["options"])) {
		$sel_options = $_POST["options"];
	}


	if(isset($_POST["subj_email"]))	{
		$subj_email = mysql_real_escape_string(htmlspecialchars($_POST["subj_email"]));
		
		if(!subject_exists($subj_email)) {

			$query = "INSERT INTO subjects (`first_name`, `last_name`, `gender`, `email`)
					VALUES ('".$subj_first_name."', '".$subj_last_name."', '".$subj_gender."', '".$subj_email."') ";
			 
			$result = mysql_query($query, $dbconnect);
			confirm_query($result);
			$subj_id = mysql_insert_id();
			$mesaj[] = "Your request has been sent. Blabla.";
			$_SESSION["mesaj"] = $mesaj;
			
			if(isset($sel_options)) {
				foreach($sel_options as $list_id) {
					$query = "INSERT INTO rel_subj_list (`list_id`, `subj_id`) VALUES ('".$list_id."', '".$subj_id."')";
					$result = mysql_query($query, $dbconnect);
					confirm_query($result);
				}
			}


		} else {
			$mesaj[] = "This email adress is already in the database.";
			$_SESSION["mesaj"] = $mesaj;
		}
	}
}
?>


<div id="wrapper">

	<div id="main_content">
			<div id="lang">
				<a title="English" href="<?php echo get_url() ?>?lang=en">
					<img class="lang-icon" alt="English" src="images/en.gif">
				</a>
				<a title="Română" href="<?php echo get_url() ?>?lang=ro">
					<img class="lang-icon" alt="Română" src="images/ro.gif">
				</a>
			</div>

		<p class="title">Prescriptive Index</p>

		<div id="info" class="tab active_tab" style="display:block;" >
			<h1 class="info toggle"><?php __("About this project")?></h1>
			<div class="info content">
				<p>One morning, when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible vermin. He lay on his armour-like back, and if he lifted his head a little he could see his brown belly, slightly domed and divided by arches into stiff sections. The bedding was hardly able to cover it and seemed ready to slide off any moment.</p>
				<p>His many legs, pitifully thin compared with the size of the rest of him, waved about helplessly as he looked. "What's happened to me? " he thought. It wasn't a dream. His room, a proper human room although a little too small, lay peacefully between its four familiar walls.</p>
				<p>A collection of textile samples lay spread out on the table - Samsa was a travelling salesman - and above it there hung a picture that he had recently cut out of an illustrated magazine and housed in a nice, gilded frame. It showed a lady fitted out with a fur hat and fur boa who sat upright, raising a heavy fur muff that covered the whole of her lower arm towards the viewer.</p>
			</div>
		</div>

		<div id="join">
			<h1 class="join"><?php __("Join the study") ?></h1>
			<?php output_message() ?>
			<form id="" action="" method="post">
			     <div class="ro">
					<fieldset>
						<label for="subj_first_name"><?php __("First Name") ?>:</label>
						<input class="required" name="subj_first_name" type="text" value="" />
						<label for="subj_last_name"><?php __("Last Name") ?>:</label>
						<input class="required" name="subj_last_name" type="text" value="" />
						<label for="subj_gender"><?php __("Gender") ?>:</label>
						<select name="subj_gender">
							<option value="m"><?php __("male") ?></option>
							<option value="f"><?php __("female") ?></option>
						</select>
						<label for="subj_email"><?php __("Email") ?>:</label>
						<input class="required" name="subj_email" type="text" value="" />
					</fieldset>
				</div>
				<div class="en">
					<fieldset>
						<label for="options[]"><?php __("I am interested in") ?>:</label>

						<?php          
							$all_lists = get_public_lists ();
							
							while ($row = mysql_fetch_array($all_lists)) {
							$list_id = $row["list_id"];
							$list_name_ro = decode($row["name"], "ro");
							$list_name_en = decode($row["name"], "en");
							$list_name = decode($row["name"], $lang);
						?>
							<input type="checkbox" value="<?php echo $list_id ?>" name="options[]"  /><?php echo $list_name ?><br />
						<?php 
							}
						?>

					</fieldset>
				</div>
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