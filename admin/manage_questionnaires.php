<?php require_once("../includes/header.php") ?>
<?php $_utils = new Utils() ?>
	 
	 <h1 class="quest"><?php __("Questionnaire Management") ?></h1>
	 
	 <div id="list_details">
		  <?php output_message() ?>
		  <ul>
			   <li class="head">
			   <span class="name"><?php __("Name") ?></span>
			   <span class="description"><?php __("Description") ?></span>
			   </li>
		  
		  <?php          
			   $result = get_all_questionnaires ();
			   while ($row = mysql_fetch_array($result)) {
				    $questionnaire_id = $row["questionnaire_id"];
				    $questionnaire_name = stripslashes(decode($row["name"], $lang));
				    $questionnaire_desc = stripslashes(decode($row["desc"], $lang));
		  ?>
		  
			   <li>
				    <span class="name"><?php echo $questionnaire_name ?></span>
				    <span class="description"><?php echo $questionnaire_desc ?></span>
				    <span class="view"><a href="view_quest.php?questionnaire_id=<?php echo $questionnaire_id ?>"><?php __("View") ?></a></span>
				    <span class="edit"><a href="edit_quest.php?questionnaire_id=<?php echo $questionnaire_id ?>"><?php __("Edit") ?></a></span>
			   </li>
		  <?php 
			   }
		  ?>
		  </ul>
		  <p class="clear"><a href="edit_quest.php"><?php __("Add questionnaire") ?></a></p>
	 </div>
<?php require_once("../includes/footer.php") ?>
