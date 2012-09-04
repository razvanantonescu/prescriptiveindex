<?php require_once("../includes/init.php") ?>
<?php $lang = set_language() ?>

<?php
   if(isset($_POST["submit"])){
// echo "<pre>"; print_r($_POST); die;
      if(isset($_POST["action"])) {
         $action = $_POST["action"];
      } else {
         redirect("manage_questionnaires.php");
      }
   } else {
      if(isset($_GET["action"])) {
         $action = $_GET["action"];
      } else {
         redirect("manage_questionnaires.php");
      }
   }

   if(isset($_REQUEST["questionnaire_id"])) $questionnaire_id = $_REQUEST["questionnaire_id"];
   if(isset($_POST["quest_title_ro"])) $questionnaire_name["ro"] = htmlspecialchars($_POST["quest_title_ro"]);
   if(isset($_POST["quest_title_en"])) $questionnaire_name["en"] = htmlspecialchars($_POST["quest_title_en"]);
   if(isset($_POST["quest_desc_ro"])) $questionnaire_desc["ro"] = htmlspecialchars($_POST["quest_desc_ro"]);  
   if(isset($_POST["quest_desc_en"])) $questionnaire_desc["en"] = htmlspecialchars($_POST["quest_desc_en"]);

   $questionnaire_name = mysql_real_escape_string(json_encode($questionnaire_name));
   $questionnaire_desc = mysql_real_escape_string(json_encode($questionnaire_desc));

   if(isset($_POST["quest_max_score"])) $max_score = htmlspecialchars($_POST["quest_max_score"]);
   if(isset($_POST["display_type"])) $display_type = $_POST["display_type"];
   if(isset($_POST["display_type"])) $quest_type = $_POST["quest_type"];

   if(isset($_POST["number_of_questions"])) $number_of_questions = $_POST["number_of_questions"];


// ACTION == ADD
if ($action == "add") {

      $mesaj = array();
      $query = "INSERT INTO questionnaires (`name`, `desc`, `max_score`, `display_type`, `quest_type`)
               VALUES ('".$questionnaire_name."',  '".$questionnaire_desc."', '".$max_score."', '".$display_type."', '".$quest_type."')";
      
      if ($result = mysql_query($query, $dbconnect)) {
            $questionnaire_id = mysql_insert_id();
            $questionnaire_name = get_questionnaire_name($questionnaire_id, $lang);
            $mesaj[] = "{$questionnaire_id}. {$questionnaire_name} was added to database.";
      
            //get the questions
            for ($index_q = 1; $index_q <= $number_of_questions; $index_q++) {

               $question_type = $_POST["question_".$index_q."_type"];
               $question["ro"] = htmlspecialchars($_POST["question_".$index_q."_ro"]);
               $question["en"] = htmlspecialchars($_POST["question_".$index_q."_en"]);
               $question_name = mysql_real_escape_string (json_encode($question));
   
               $query = "INSERT INTO questions (`questionnaire_id`,`name`,`type`)
                        VALUES ('".$questionnaire_id."', '".$question_name."', '".$question_type."')";
               if ($result = mysql_query($query, $dbconnect)) {
                  $question_id = mysql_insert_id();
                  $question_name = get_question_name($question_id, $lang);
                  $mesaj[] = "{$question_name} was added to {$questionnaire_name}.";
                  
                  for ($index_c = 1; $index_c <= $_POST['number_of_choices_q'.$index_q]; $index_c++) {
                  
                     $choice["ro"] = addslashes($_POST["question_".$index_q."_choice_".$index_c."_ro"]);
                     $choice["en"] = addslashes($_POST["question_".$index_q."_choice_".$index_c."_en"]);
                     $choice_name = json_encode($choice);
                     $choice_name = mysql_real_escape_string($choice_name);
                     $choice_score = addslashes($_POST["question_".$index_q."_choice_".$index_c."_score"]);
                     $query = "INSERT INTO choices (`question_id`, `name`, `score`)
                              VALUES ('".$question_id."', '".$choice_name."', '".$choice_score."')";
                     $result = mysql_query($query, $dbconnect);
                     confirm_query($result);
                  }
               }
            }
            
            for ($index_r = 1; $index_r <= 5; $index_r++) {
               $rating_min_val = addslashes($_POST["min_val_".$index_r]);
               $rating_max_val = addslashes($_POST["max_val_".$index_r]);
               $rating_scoring = addslashes($_POST["scoring_".$index_r]);
               $rating_value = addslashes($_POST["value_".$index_r]);
               $query = "INSERT INTO ratings (`questionnaire_id`, `min_val`, `max_val`, `scoring`, `value`) 
                        VALUES ('".$questionnaire_id."', '".$rating_min_val ."', '".$rating_max_val."', '".$rating_scoring."', '".$rating_value."')";
               $result = mysql_query($query, $dbconnect);
               confirm_query($result);            
            }
      }
      $_SESSION["mesaj"] = $mesaj;
      //output_message(); exit;
      redirect("view_quest.php?questionnaire_id={$questionnaire_id}");
}


// EDIT

if ($action == "edit") {

      $query = "UPDATE `questionnaires` SET 
               `name` = '".$questionnaire_name."', 
               `desc` = '".$questionnaire_desc."', 
               `max_score` = '".$max_score."', 
               `display_type` = '".$display_type."', 
               `quest_type` = '".$quest_type."' 
               WHERE `questionnaire_id` = '".$questionnaire_id."'
               ";
      $result = mysql_query($query, $dbconnect);
      confirm_query($result);
      if (mysql_affected_rows() == 1) {
         $questionnaire_name = get_questionnaire_name($questionnaire_id, $lang);
         $mesaj[] = "{$questionnaire_name} was updated.";
      }


      //get & process the questions for this questionnaire

      $rel_questions = get_rel_questions_for_questionnaire($questionnaire_id); // get all questions related to this questionnaire
      $sel_questions = array();		// empty array to collect id's of the remaining questions

      for ($index_q = 1; $index_q <= $number_of_questions; $index_q++) {

            $question_type = $_POST["question_".$index_q."_type"];
            $question["ro"] = htmlspecialchars($_POST["question_".$index_q."_ro"]);
            $question["en"] = htmlspecialchars($_POST["question_".$index_q."_en"]);
            $question_name = mysql_real_escape_string(json_encode($question));


/*
 * intrebare existenta
 */
            if(isset($_POST["question_id_".$index_q])) { 
               $question_id = $_POST["question_id_".$index_q];
               $sel_questions[] = $question_id;
               $query = "UPDATE questions SET 
                        `name` = '".$question_name."', 
                        `type` = '".$question_type."' 
                        WHERE `question_id` = '".$question_id."' 
                        ";
               $result = mysql_query($query, $dbconnect);
               confirm_query($result);
               if (mysql_affected_rows() == 1) {
                  $question_name = get_question_name($question_id, $lang);
                  $mesaj[] = "{$question_name} was updated.";
               }

					$rel_choices = get_rel_choices_for_question($question_id);
					$sel_choices = array();			// empty array to collect id's of the remianing choices

               for ($index_c = 1; $index_c <= $_POST['number_of_choices_q'.$index_q]; $index_c++) {
   
                  $choice["ro"] = htmlspecialchars($_POST["question_".$index_q."_choice_".$index_c."_ro"]);
                  $choice["en"] = htmlspecialchars($_POST["question_".$index_q."_choice_".$index_c."_en"]);
                  $choice_name = mysql_real_escape_string(json_encode($choice));
                  $choice_score = htmlspecialchars($_POST["question_".$index_q."_choice_".$index_c."_score"]);

		            if(isset($_POST["question_".$index_q."_choice_".$index_c."_id"])) {
							$choice_id = $_POST["question_".$index_q."_choice_".$index_c."_id"];
							$sel_choices[] = $choice_id;
							$query = "UPDATE choices SET
										`name` = '".$choice_name."', 
										`score` = '".$choice_score."'
										WHERE `choice_id` = '".$choice_id."'
										";
							$result = mysql_query($query, $dbconnect);
							confirm_query($result);
						} else {
                     $query = "INSERT INTO choices (`question_id`, `name`, `score`)
                              VALUES ('".$question_id."', '".$choice_name."', '".$choice_score."')";
							if ($result = mysql_query($query, $dbconnect)) {
								$choice_id = mysql_insert_id();
								$sel_choices[] = $choice_id;
							}
						}
						
               }

					// remove deleted choices
					foreach ($rel_choices as $choice_id) {
						if (!in_array((int)$choice_id, $sel_choices)) {
							$query = "DELETE from choices WHERE `choice_id` = '".$choice_id."' ";
							$result = mysql_query($query, $dbconnect);
							confirm_query($result);
						}
					}

/*
 * intrebare noua
 */
            } else {
               $query = "INSERT INTO questions (`questionnaire_id`,`name`,`type`)
                        VALUES ('".$questionnaire_id."', '".$question_name."', '".$question_type."')";
               if ($result = mysql_query($query, $dbconnect)) {
                  $question_id = mysql_insert_id();
                  $question_name = get_question_name($question_id, $lang);
                  $questionnaire_name = get_questionnaire_name($questionnaire_id, $lang);
                  $mesaj[] = "{$question_name} was added to {$questionnaire_name}.";
                  
                  for ($index_c = 1; $index_c <= $_POST['number_of_choices_q'.$index_q]; $index_c++) {
                  
                     $choice["ro"] = htmlspecialchars($_POST["question_".$index_q."_choice_".$index_c."_ro"]);
                     $choice["en"] = htmlspecialchars($_POST["question_".$index_q."_choice_".$index_c."_en"]);
                     $choice_name = mysql_real_escape_string(json_encode($choice));
                     $choice_score = htmlspecialchars($_POST["question_".$index_q."_choice_".$index_c."_score"]);
                     $query = "INSERT INTO choices (`question_id`, `name`, `score`)
                              VALUES ('".$question_id."', '".$choice_name."', '".$choice_score."')";
                     $result = mysql_query($query, $dbconnect);
                     confirm_query($result);
                  }
               }
            }
      }

      for ($index_r = 1; $index_r <= 5; $index_r++) {
            $rating_id = $_POST["rating_id_".$index_r];
            $rating_min_val = htmlspecialchars($_POST["min_val_".$index_r]);
            $rating_max_val = htmlspecialchars($_POST["max_val_".$index_r]);
            $rating_scoring = htmlspecialchars($_POST["scoring_".$index_r]);
            $rating_value = htmlspecialchars($_POST["value_".$index_r]);
            $query = "UPDATE ratings SET
                     `min_val` = '".$rating_min_val."',
                     `max_val` = '".$rating_max_val."',
                     `scoring` = '".$rating_scoring."', 
                     `value` = '".$rating_value."' 
                     WHERE `rating_id` = '".$rating_id."'
                     ";
            $result = mysql_query($query, $dbconnect);
            confirm_query($result);            
      }

      // remove deleted questions
      foreach ($rel_questions as $question_id) {
         if (!in_array((int)$question_id, $sel_questions)) {
            $query = "DELETE from questions WHERE `question_id` = '".$question_id."' ";
            $result = mysql_query($query, $dbconnect);
            confirm_query($result);
            
            // remove related choices
            $query = "DELETE from choices WHERE `question_id` = '".$question_id."' ";
            $result = mysql_query($query, $dbconnect);
            confirm_query($result);
         }
      }

      $_SESSION["mesaj"] = $mesaj;
      redirect("view_quest.php?questionnaire_id={$questionnaire_id}");
}



// a little check

$query = "SELECT * FROM questions ORDER BY question_id ASC;";
$result = mysql_query($query, $dbconnect);
confirm_query($result);
while ($row = mysql_fetch_array($result)) {
      $question_id = $row["question_id"];
      $question_name_ro = decode($row["name"], "ro");
      $question_name_en = decode($row["name"], "en");
      echo $question_id ." / ". $question_name_ro ." / ". $question_name_en . "<br />";
}

?>
