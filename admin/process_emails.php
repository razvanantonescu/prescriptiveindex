<?php require_once("../includes/init.php") ?>
<?php $lang = set_language() ?>

<?php
   if(isset($_POST["submit"])){
	 echo "<pre>";print_r($_POST);echo "<pre>";//die;
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

   $email_name = array();
	$email_body = array();
	
	if(isset($_REQUEST["email_id"])) $email_id = $_REQUEST["email_id"];
   if(isset($_POST["email_name_ro"])) $email_name["ro"] = htmlspecialchars($_POST["email_name_ro"]);
   if(isset($_POST["email_name_en"])) $email_name["en"] = htmlspecialchars($_POST["email_name_en"]);
   if(isset($_POST["email_body_ro"])) $email_body["ro"] = htmlspecialchars($_POST["email_body_ro"]);  
   if(isset($_POST["email_body_en"])) $email_body["en"] = htmlspecialchars($_POST["email_body_en"]);

   $email_name = mysql_real_escape_string(json_encode($email_name));
   $email_body = mysql_real_escape_string(json_encode($email_body));


/*
 * delete email template
 */

   if ($action == "delete") {
      $mesaj = array();
      $template_name = get_template_name($email_id, $lang);

		$query = "DELETE FROM emails WHERE email_id = '".$email_id."'";
      $result = mysql_query($query, $dbconnect);
      confirm_query($result);
      if (mysql_affected_rows() == 1) {
         $mesaj[] = "Template {$template_name} has been deleted.";
      }
		
		$query = "DELETE from  rel_studies_email WHERE email_id = '".$email_id."'";
      $result = mysql_query($query, $dbconnect);
      confirm_query($result);
      if (mysql_affected_rows() == 1) {
         $mesaj[] = "Relations to this email template were removed.";
      }

      $_SESSION["mesaj"] = $mesaj;
      redirect("manage_emails.php");
	}


/*
 * edit email template
 */
   
   if ($action == "edit") {

      $query = "UPDATE `emails` SET 
               `name` = '".$email_name."',
               `body` = '".$email_body."'  
               WHERE `email_id` = '".$email_id."'
               ";
      $result = mysql_query($query, $dbconnect);
      //confirm_query($result);
      redirect("view_email.php?email_id=".$email_id);
   }

/*
 * add email template
 */
   
   if ($action == "add") {

      $query = "INSERT INTO emails (`name`, `body`)
               VALUES ('".$email_name."', '".$email_body."')";
      if ($result = mysql_query($query, $dbconnect)) {
            $email_id = mysql_insert_id();
		      redirect("view_email.php?email_id=".$email_id);
		}
   }

?>