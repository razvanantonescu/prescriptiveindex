<?php require_once("../includes/init.php") ?>
<?php $lang = set_language() ?>
<?php
   if(isset($_POST["submit"])){

		echo "<pre>";print_r($_POST);echo "<pre>";//die;

		if(isset($_POST["action"])) {
         $action = $_POST["action"];
      } else {
         redirect("manage_studies.php");
      }
   } else {
      if(isset($_GET["action"])) {
         $action = $_GET["action"];
      } else {
         redirect("manage_studies.php");
      }
   }

   if(isset($_REQUEST["study_id"])) $study_id = $_REQUEST["study_id"];
   if(isset($_POST["study_name_ro"])) $study_name["ro"] = htmlspecialchars($_POST["study_name_ro"]);
   if(isset($_POST["study_name_en"])) $study_name["en"] = htmlspecialchars($_POST["study_name_en"]);
   if(isset($_POST["study_desc_ro"])) $study_desc["ro"] = htmlspecialchars($_POST["study_desc_ro"]);  
   if(isset($_POST["study_desc_en"])) $study_desc["en"] = htmlspecialchars($_POST["study_desc_en"]);

   $sel_questionnaires = array();
   if (isset($_POST["questionnaires"])) $sel_questionnaires = $_POST["questionnaires"];
   $sel_list= array();
   if (isset($_POST["list"])) $sel_list = $_POST["list"];
   $sel_template = null;
   if (isset($_POST["email_template"])) $sel_template = $_POST["email_template"];

   $study_name = mysql_real_escape_string(json_encode($study_name));
   $study_desc = mysql_real_escape_string(json_encode($study_desc));

// edit STUDY
   
   if ($action == "edit") {

      $query = "UPDATE `studies` SET 
               `name` = '".$study_name."',
               `desc` = '".$study_desc."'  
               WHERE `study_id` = '".$study_id."'
               ";

      $result = mysql_query($query, $dbconnect);
      confirm_query($result);

      foreach($sel_questionnaires as $questionnaire_id) {
         $query = "INSERT INTO rel_questionnaire_study (`questionnaire_id`, `study_id`) VALUES ('".$questionnaire_id."', '".$study_id."')";
         $result = mysql_query($query, $dbconnect);
      }

      $rel_questionnaires = get_sel_quest_for_study($study_id);
      foreach ($rel_questionnaires as $tester) {
         if (!in_array((int)$tester, $sel_questionnaires)) {
            $query = "DELETE FROM rel_questionnaire_study WHERE questionnaire_id = '".$tester."' AND study_id = '".$study_id."'";
            $result = mysql_query($query, $dbconnect);
				confirm_query($result);
         }
      }

		$sel_subjects = array();
		foreach($sel_list as $list_id) {
         $query = "INSERT IGNORE INTO rel_list_study (`list_id`, `study_id`) VALUES ('".$list_id."', '".$study_id."')";
         $result = mysql_query($query, $dbconnect);
			confirm_query($result);

			$subjects = get_active_subj_for_list($list_id);
			while ($row = mysql_fetch_array($subjects)) {
			
				if($sel_template != null) {
					$template_body = get_template_body($sel_template, $lang);
					$subj_id = $row['subj_id'];
					$subj_name = $row['first_name'] ." ". $row['last_name'];
					$subj_email = $row['email'];
					$title = get_study_name($study_id, $lang);
					
					$rel_template = get_rel_template_id_for_study($study_id);
					
					if($sel_template == $rel_template && $sel_template != null) {
							$query="INSERT IGNORE INTO mails (`study_id`, `subj_id`, `nume`, `email`, `titlu`, `body`)
									VALUES ('".$study_id."', '".$subj_id."', '".$subj_name."', '".$subj_email."', '".$title."', '".$template_body."');";
					} else {
						$query="REPLACE INTO mails (`study_id`, `subj_id`, `nume`, `email`, `titlu`, `body`)
									VALUES ('".$study_id."', '".$subj_id."', '".$subj_name."', '".$subj_email."', '".$title."', '".$template_body."');";
					}
					$result = mysql_query($query, $dbconnect);
					confirm_query($result);
					$sel_subjects[] = $subj_id;
				}
			}
      }

      $rel_list = get_sel_list_for_study($study_id);
      foreach ($rel_list as $tester) {
         if (!in_array((int)$tester, $sel_list)) {
            $query = "DELETE FROM rel_list_study WHERE list_id = '".$tester."' AND study_id = '".$study_id."'";
            $result = mysql_query($query, $dbconnect);
				confirm_query($result);
				
				$subjects = get_subj_for_list($tester);
				while ($row = mysql_fetch_array($subjects)) {
					$subj_id = $row['subj_id'];
					if(!in_array((int)$subj_id, $sel_subjects)) {
					$query="DELETE FROM mails
								WHERE  study_id = '".$study_id."' AND  subj_id = '".$subj_id."' AND status = 0;
								";
					$result = mysql_query($query, $dbconnect);
					confirm_query($result);
					echo $query . "<br />";
					}
				}
         }
      }

		if($sel_template != null) {
			$rel_template = get_rel_template_id_for_study($study_id);
			
			if($sel_template != $rel_template) {
				$query = "DELETE FROM rel_studies_email WHERE email_id = '".$rel_template."';
				";
				$result = mysql_query($query, $dbconnect);
				confirm_query($result);
			}

			$query = "INSERT IGNORE INTO rel_studies_email (`study_id`, `email_id`) VALUES ('".$study_id."', '".$sel_template."')";
			$result = mysql_query($query, $dbconnect);
			confirm_query($result);
		}


      redirect("view_study.php?study_id={$study_id}");
   }

/*
 * add study
 */
   
   if ($action == "add") {

      $query = "INSERT INTO studies (`name`, `desc`)
               VALUES ('".$study_name."', '".$study_desc."')";

      if ($result = mysql_query($query, $dbconnect)) {
            $study_id = mysql_insert_id();

            if(!empty($sel_questionnaires)){
               foreach($sel_questionnaires as $questionnaire_id) {
                  $query = "INSERT INTO rel_questionnaire_study (`questionnaire_id`, `study_id`) VALUES ('".$questionnaire_id."', '".$study_id."')";
                  $result = mysql_query($query, $dbconnect);
                  confirm_query($result);
               }
            }

            if(!empty($sel_list)){
               foreach($sel_list as $list_id) {
                  $query = "INSERT INTO rel_list_study (`list_id`, `study_id`) VALUES ('".$list_id."', '".$study_id."')";
                  $result = mysql_query($query, $dbconnect);
                  confirm_query($result);

						$subjects = get_active_subj_for_list($list_id);
						while ($row = mysql_fetch_array($subjects)) {
							if($sel_template != null) {
								$template_body = get_template_body($sel_template, $lang);
								$subj_id = $row['subj_id'];
								$subj_name = $row['first_name'] ." ". $row['last_name'];
								$subj_email = $row['email'];
								$query="INSERT IGNORE INTO mails (`study_id`, `subj_id`, `nume`, `email`, `titlu`, `body`)
											VALUES ('".$study_id."', '".$subj_id."', '".$subj_name."', '".$subj_email."', 'Un titlu', '".$template_body."');
											";
								$result = mysql_query($query, $dbconnect);
								confirm_query($result);
							}
						}
               }
            }

				if($sel_template != null) {
					$rel_template = get_rel_template_id_for_study($study_id);
					$query = "INSERT INTO rel_studies_email (`study_id`, `email_id`) VALUES ('".$study_id."', '".$sel_template."')";
					$result = mysql_query($query, $dbconnect);
					confirm_query($result);
				}

      }
      redirect("view_study.php?study_id={$study_id}");
   }

?>