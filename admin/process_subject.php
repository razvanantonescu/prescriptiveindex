<?php require_once("../includes/init.php") ?>
<?php $lang = set_language() ?>

<?php
   if(isset($_POST["submit"])){
	 //echo "<pre>";print_r($_POST);echo "<pre>";exit;
      if(isset($_POST["action"])) {
         $action = $_POST["action"];
      } else {
         redirect("manage_subjects.php");
      }
   } else {
      if(isset($_GET["action"])) {
         $action = $_GET["action"];
      } else {
         redirect("manage_subjects.php");
      }
   }
   
   if(isset($_REQUEST["subj_id"])) $subj_id = $_REQUEST["subj_id"];
   if(isset($_POST["subj_first_name"]))	$subj_first_name = mysql_real_escape_string(htmlspecialchars($_POST["subj_first_name"]));
   if(isset($_POST["subj_last_name"]))	$subj_last_name = mysql_real_escape_string(htmlspecialchars($_POST["subj_last_name"]));
   if(isset($_POST["subj_gender"]))	$subj_gender = $_POST["subj_gender"];
   if(isset($_POST["subj_status"]))	$subj_status = $_POST["subj_status"];
   if(isset($_POST["subj_email"]))		$subj_email = mysql_real_escape_string(htmlspecialchars($_POST["subj_email"]));

   $sel_lists = array();
   if (isset($_POST["lists"])) $sel_lists = $_POST["lists"];

// edit subject
   
   if ($action == "edit") {
      $mesaj = array();
      $query = "UPDATE subjects SET 
               `first_name` = '".$subj_first_name."',
               `last_name` = '".$subj_last_name."',
               `gender` = '".$subj_gender."',
               `status` = '".$subj_status."',
               `email` = '".$subj_email."'  
               WHERE `subj_id` = '".$subj_id."'
               ";
   
      $result = mysql_query($query, $dbconnect);
      if (mysql_affected_rows() == 1) {
         $mesaj[] = "The subject details have been updated.";
      }

      $rel_lists = get_rel_list_for_subj($subj_id);

      foreach ($rel_lists as $list_id) {
         if (!in_array((int)$list_id, $sel_lists)) {
            $query = "DELETE FROM rel_subj_list WHERE `list_id` = '".$list_id."' ";
            $result = mysql_query($query, $dbconnect);
            confirm_query($result);
            if (mysql_affected_rows() == 1) {
               $list_name = get_list_name($list_id, $lang);
               $mesaj[] = "Subject has been deleted from list {$list_name}.";
            }
         }
      }

      foreach($sel_lists as $list_id) {
         if (!in_array((int)$list_id, $rel_lists)) {
            $query = "INSERT INTO rel_subj_list (`list_id`, `subj_id`) VALUES ('".$list_id."', '".$subj_id."')";
            $result = mysql_query($query, $dbconnect);
            confirm_query($result);
            if (mysql_affected_rows() == 1) {
               $list_name = get_list_name($list_id, $lang);
               $mesaj[] = "Subject has been added to list {$list_name}.";
            }
         }
      }

      $_SESSION["mesaj"] = $mesaj;
      //output_message(); exit;
      redirect("view_subject.php?subj_id=".$subj_id);
   }
   
// add subject
   
   if ($action == "add") {
      $mesaj = array();
      $query = "INSERT INTO subjects (`first_name`, `last_name`, `gender`, `email`)
               VALUES ('".$subj_first_name."', '".$subj_last_name."', '".$subj_gender."', '".$subj_email."') ";
   
      $result = mysql_query($query, $dbconnect);
      confirm_query($result);
      $subj_id = mysql_insert_id();
      if (mysql_affected_rows() == 1) {
         $mesaj[] = "{$subj_first_name} {$subj_last_name} was added to database.";
      }
      foreach($sel_lists as $list_id) {
         $query = "INSERT INTO rel_subj_list (`list_id`, `subj_id`) VALUES ('".$list_id."', '".$subj_id."')";
         $result = mysql_query($query, $dbconnect);
         if (mysql_affected_rows() == 1) {
            $list_name = get_list_name($list_id, $lang);
            $mesaj[] = "Subject has been added to list {$list_name}.";
         }
      }

      $_SESSION["mesaj"] = $mesaj;
      redirect("view_subject.php?subj_id=".$subj_id);
   }

// delete subject
   
   if ($action == "delete") {

      $subj_name = get_subj_name($subj_id, $lang);
      $mesaj = array();
      $query = "DELETE FROM subjects WHERE subj_id = '".$subj_id."' ";
	 //echo $query; exit;
      $result = mysql_query($query, $dbconnect);
      confirm_query($result);
      if (mysql_affected_rows() == 1) {
         $mesaj[] = "Subject {$subj_name} has been deleted.";
      }

      $query = "DELETE FROM rel_subj_list WHERE subj_id = '".$subj_id."' ";
      $result = mysql_query($query, $dbconnect);
      confirm_query($result);
      if (mysql_affected_rows() >= 1) {
         $mesaj[] = "Relations to {$subj_name} were removed.";
      }

      $_SESSION["mesaj"] = $mesaj;
      redirect("manage_subjects.php");
   }
?>