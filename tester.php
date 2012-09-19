<?php ob_start() ?>
<?php session_start(); ?>
<?php require_once("mysql_conf.php"); ?>
<?php //require_once("includes/class.php"); ?>
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

<div id="wrapper">
	
	<div id="main_content">
		<p class="title">Prescriptive Index</p>

		<select id="study_id" name="study_id">
		<?php
			$result = get_all_study_ids();
			while($row = mysql_fetch_array($result)) {
				?>
				<option value="<?php echo $row['study_id'] ?>"><?php echo get_study_name($row['study_id'], 'ro') ?></option>
				<?php
			}
		?>
		</select>
		
		<div id="list_details" style="margin-top:30px;"></div>
	</div>


<script>
  
	$(document).ready(function() {
		 $("#study_id").change(function() {
			  $("#list_details").fadeOut(20);

			  $.ajax({
					type: 'POST',
					url: 'include_study.php',
					data: 'study_id='+$("#study_id").val(),
					success: function(data) {
						 $("#list_details").html(data);
						 $("#list_details").fadeIn();
					}
			  });
		 });
	});
  
</script>

	<div id="footer">
		<div id="bottom_nav">
			<a href="admin">admin</a>
		</div>
		<div id="copyright">&copy; 2012 UVT</div>
	</div>
</div>
</body>
</html>