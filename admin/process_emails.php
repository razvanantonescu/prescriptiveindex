<?php require_once("../includes/init.php") ?>
<?php $lang = set_language() ?>

<?php
   if(isset($_POST["submit"])){
	 //echo "<pre>";print_r($_POST);echo "<pre>";exit;
      if(isset($_POST["action"])) {
         $action = $_POST["action"];
      } else {
         redirect("manage_emails.php");
      }
   } else {
      if(isset($_GET["action"])) {
         $action = $_GET["action"];
      } else {
         redirect("manage_emails.php");
      }
   }

   if(isset($_REQUEST["email_id"])) $email_id = $_REQUEST["email_id"];
   if(isset($_POST["email_name_ro"])) $email_name["ro"] = htmlspecialchars($_POST["email_name_ro"]);
   if(isset($_POST["email_name_en"])) $email_name["en"] = htmlspecialchars($_POST["email_name_en"]);
   if(isset($_POST["email_body_ro"])) $email_body["ro"] = htmlspecialchars($_POST["email_body_ro"]);  
   if(isset($_POST["email_body_en"])) $email_body["en"] = htmlspecialchars($_POST["email_body_en"]);

   $sel_studies = array();
   if (isset($_POST["studies"])) $sel_studies = $_POST["studies"];

   $email_name = mysql_real_escape_string(json_encode($email_name));
   $email_body = mysql_real_escape_string(json_encode($email_body));



//////////////////////////////////////////////////////////////////////////////////////// edit email template
   
   if ($action == "edit") {

      $query = "UPDATE `emails` SET 
               `name` = '".$email_name."',
               `body` = '".$email_body."'  
               WHERE `email_id` = '".$email_id."'
               ";
      $result = mysql_query($query, $dbconnect);
      confirm_query($result);

      $rel_studies = get_rel_studies_for_email($email_id);
      foreach ($rel_studies as $tester) {
         if (!in_array((int)$tester, $sel_studies)) {
            $query = "DELETE FROM rel_studies_email WHERE email_id = '".$email_id."' AND study_id = '".$tester."'";
            $result = mysql_query($query, $dbconnect);
         }
      }

      foreach($sel_studies as $study_id) {
         $query = "INSERT INTO rel_studies_email (`study_id`, `email_id`) VALUES ('".$study_id."', '".$email_id."')";
         $result = mysql_query($query, $dbconnect);
      }
      redirect("view_email.php?email_id=".$email_id);
   }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// add study
   
   if ($action == "add") {

      $query = "INSERT INTO emails (`name`, `body`)
               VALUES ('".$email_name."', '".$email_body."')";

      if ($result = mysql_query($query, $dbconnect)) {
            $email_id = mysql_insert_id();

            if(!empty($sel_studies)){
               foreach($sel_studies as $study_id) {
                  $query = "INSERT INTO rel_studies_email (`study_id`, `email_id`) VALUES ('".$study_id."', '".$email_id."')";
                  $result = mysql_query($query, $dbconnect);
                  confirm_query($result);
               }
            }
      }
      redirect("view_email.php?email_id=".$email_id);
   }

?>