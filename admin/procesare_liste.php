<?php require_once("../includes/init.php") ?>
<?php $lang = set_language() ?>

<?php
   if(isset($_POST["submit"])){
	 //echo "<pre>";print_r($_POST);echo "<pre>";exit;
      if(isset($_POST["action"])) {
         $action = $_POST["action"];
      } else {
         redirect("manage_lists.php");
      }
   } else {
      if(isset($_GET["action"])) {
         $action = $_GET["action"];
      } else {
         redirect("manage_lists.php");
      }
   }

   if(isset($_REQUEST["list_id"])) $list_id = $_REQUEST["list_id"];
   if(isset($_POST["list_name_ro"])) $list_name["ro"] = htmlspecialchars($_POST["list_name_ro"]);
   if(isset($_POST["list_name_en"])) $list_name["en"] = htmlspecialchars($_POST["list_name_en"]);
   if(isset($_POST["list_desc_ro"])) $list_desc["ro"] = htmlspecialchars($_POST["list_desc_ro"]);
   if(isset($_POST["list_desc_en"])) $list_desc["en"] = htmlspecialchars($_POST["list_desc_en"]);
   if(isset($_POST["public"])) $list_public = $_POST["public"]["0"];
   //echo $list_public; exit;

   $sel_subjects = array();
   if (isset($_POST["subjects"])) $sel_subjects = $_POST["subjects"];

   $list_name = mysql_real_escape_string(json_encode($list_name));
   $list_desc = mysql_real_escape_string(json_encode($list_desc));

//   edit list
   
   if ($action == "edit") {
      $mesaj = array();
      $query = "UPDATE liste SET 
               `name` = '".$list_name."',
               `desc` = '".$list_desc."',  
               `public` = '".$list_public."'  
               WHERE `list_id` = '".$list_id."'";
      $result = mysql_query($query, $dbconnect);
      confirm_query($result);
      if (mysql_affected_rows() == 1) {
         $mesaj[] = "The list details have been updated.";
      }

      $rel_subjects = get_sel_subj_for_list($list_id);

      foreach ($rel_subjects as $subj_id) {
         if (!in_array((int)$subj_id, $sel_subjects)) {
            $query = "DELETE FROM rel_subj_list WHERE subj_id = '".$subj_id."' AND list_id = '".$list_id."'";
            $result = mysql_query($query, $dbconnect);
            confirm_query($result);
            if (mysql_affected_rows() == 1) {
               $subj_name = get_subj_name($subj_id);
               $mesaj[] = "Subject {$subj_name} has been removed from list.";
            }
         }
      }

      foreach($sel_subjects as $subj_id) {
         if (!in_array((int)$subj_id, $rel_subjects)) {
            $query = "INSERT INTO rel_subj_list (`list_id`, `subj_id`) VALUES ('".$list_id."', '".$subj_id."')";
            $result = mysql_query($query, $dbconnect);
            confirm_query($result);
            if (mysql_affected_rows() == 1) {
               $subj_name = get_subj_name($subj_id);
               $mesaj[] = "Subject {$subj_name} has been added to list.";
            }
         }
      }

      $_SESSION["mesaj"] = $mesaj;
      //output_message();exit;
      redirect("view_list.php?list_id=".$list_id);
      redirect("manage_lists.php");
   }
   
// add list
   
   if ($action == "add") {
      $mesaj = array();
      $query = "INSERT INTO liste (`name`, `desc`, `public`)
               VALUES ('".$list_name."', '".$list_desc."', '".$list_public."')";

      $result = mysql_query($query, $dbconnect);
      confirm_query($result);
      $list_id = mysql_insert_id();
      if (mysql_affected_rows() == 1) {
         $list_name = get_list_name($list_id, $lang);
         $mesaj[] = "List {$list_name} has been created.";
      }
 
      foreach($sel_subjects as $subj_id) {
            $query = "INSERT INTO rel_subj_list (`list_id`, `subj_id`) VALUES ('".$list_id."', '".$subj_id."')";
            $result = mysql_query($query, $dbconnect);
            confirm_query($result);
            if (mysql_affected_rows() == 1) {
               $subj_name = get_subj_name($subj_id);
               $mesaj[] = "Subject {$subj_name} has been added to list.";
            }
      }
 
      $_SESSION["mesaj"] = $mesaj;
      //output_message(); exit;
      redirect("view_list.php?list_id=".$list_id);
      redirect("manage_lists.php");
   
   }
   /* end add list */

   /* delete list*/
   
   if ($action == "delete") {
      $mesaj = array();
      $list_name = get_list_name($list_id, $lang);

      $query = "DELETE FROM liste WHERE list_id = '".$list_id."'";
      $result = mysql_query($query, $dbconnect);
      confirm_query($result);
      if (mysql_affected_rows() == 1) {
         $mesaj[] = "List {$list_name} has been deleted.";
      }

      $query = "DELETE FROM rel_subj_list WHERE list_id = '".$list_id."'";
      $result = mysql_query($query, $dbconnect);
      confirm_query($result);
      if (mysql_affected_rows() == 1) {
         $mesaj[] = "Relations to this list were removed.";
      }

      $_SESSION["mesaj"] = $mesaj;
      redirect("manage_lists.php");
   
   }
   /* end delete list */
?>
