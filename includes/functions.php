<?php

function confirm_query($result_set) {
   if (!$result_set) {
      die("Database query failed: " . mysql_error());
   }
}

function set_language() {
   if(isset($_GET["lang"]) && $_GET["lang"]!="") {
      $lang = $_GET["lang"];
      $_SESSION["lang"] = $lang;
      return $lang;
   } else {
      if(isset($_SESSION["lang"]) && $_SESSION["lang"]!="") {
         $lang = $_SESSION["lang"];
         return $lang;
      } else {
         $lang = "ro";
         $_SESSION["lang"] = $lang;
         return $lang;
      }
   }
}

function output_message() {
   if(isset($_SESSION["mesaj"])){
      $mesaj = $_SESSION["mesaj"];
      foreach ($mesaj as $mess) {
         echo "<p class=\"mesaj\">";
	    //__(stripslashes($mess));
	    echo stripslashes($mess);
	    echo "</p>";
      }
      unset($_SESSION["mesaj"]);
   }
}

function get_language () {
   if(isset($_SESSION["lang"]) && $_SESSION["lang"]!="") {
      $lang = $_SESSION["lang"];
      return $lang;
   } else {
      return false;
   }
}

function get_url() {
   $url = $_SERVER["PHP_SELF"];
   $query = $_SERVER["QUERY_STRING"];
   return $url;
}

function redirect($target = NULL) {
   if ($target != NULL) {
	 header("Location: {$target}");
	 exit;
   }
}

function __($txt) {
   global $dbconnect;
   global $lang;
   $result = mysql_query("select * from texts where `mydata` ='".mysql_real_escape_string(htmlspecialchars($txt))."' ");
   if (!mysql_num_rows($result)) {
      mysql_query("insert into texts (`mydata`) values ('".mysql_real_escape_string(htmlspecialchars($txt))."') ");
   } else {
	 if ($lang == 'ro') {
	    $row = mysql_fetch_array($result);
	    $txt_ro = $row['ro'];
	    if($txt_ro != NULL) {
		  $txt = $txt_ro;
	    }
	 }
   }
   echo $txt;
}


function unstrip_array($array){
   foreach($array as $val){
	 if(is_array($val)){
	    $val = unstrip_array($val);
	 }else{
	    $val = stripslashes($val);
	 }
   }
   return $array;
}

function decode($var, $lang) {
   $array = get_object_vars(json_decode($var));
   unstrip_array($array);
   $return = $array[$lang];
   return $return;
}



//////////////* legate de afisare subiecti */
function get_all_subjects () {
   global $dbconnect;
   $query = "SELECT * FROM subjects ORDER BY subj_id ASC;";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   return $result;
}


function get_pending_subjects () {
   global $dbconnect;
   $query = "SELECT * FROM subjects WHERE status = 'p' ORDER BY subj_id ASC;";
   //echo $query; exit;
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   return $result;
}


function filter_active_subjects ($filter="1") {
   global $dbconnect;
   $query = "SELECT * FROM subjects WHERE ".$filter." AND status = 'a' ORDER BY subj_id ASC;";
   //echo $query; exit;
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   return $result;
}


function get_subject($subj_id) {
   global $dbconnect;
   $query = "SELECT * FROM subjects WHERE subj_id = '".$subj_id."' ";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   return $result;
}

function get_subj_name($subj_id) {
   global $dbconnect;

   $query = "SELECT `first_name`, `last_name` FROM subjects WHERE subj_id={$subj_id}";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   $row = mysql_fetch_array($result);
   $subj_first_name = $row["first_name"];
   $subj_last_name = $row["last_name"];
   $subj_name = $subj_first_name . " " . $subj_last_name;
   return $subj_name;
}

function get_sel_subj_for_list($list_id) {
   global $dbconnect;
   $query = "SELECT rel_subj_list.subj_id FROM rel_subj_list WHERE rel_subj_list.list_id = {$list_id}";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   $return = array();
   while ($row = mysql_fetch_array($result)) {
      $return[] = $row["subj_id"];
   }
   return $return;
}

function get_subj_for_list($list_id) {
   global $dbconnect;
   $query = "SELECT rel_subj_list.list_id, rel_subj_list.subj_id, subjects.first_name, subjects.last_name FROM rel_subj_list, subjects WHERE rel_subj_list.list_id = {$list_id} AND subjects.subj_id = rel_subj_list.subj_id";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   return $result;
}


function subject_exists($email) {
   global $dbconnect;
   $query = "SELECT * FROM subjects WHERE email = '{$email}'";
   $result = mysql_query($query, $dbconnect);
   if(mysql_num_rows($result) == 1) {
	 return true;
   } else {
	 return false;
   }
}

function get_subject_id($email) {
   global $dbconnect;
   $query = "SELECT subj_id FROM subjects WHERE email = '{$email}'";
   $result = mysql_query($query, $dbconnect);
   if(mysql_num_rows($result) == 1) {
	 $row = mysql_fetch_array($result);
      $subj_id = $row["subj_id"];
	 return $subj_id;
   } else {
	 return false;
   }
}



//////////////* legate de afisare liste */
function get_all_lists () {
   global $dbconnect;
   $query = "SELECT * FROM liste ORDER BY list_id ASC;";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   return $result;
}

function get_public_lists () {
   global $dbconnect;
   $query = "SELECT * FROM liste WHERE public = '1' ORDER BY list_id ASC;";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   return $result;
}

function get_list($list_id) {
   global $dbconnect;
   $query = "SELECT * FROM liste WHERE list_id={$list_id}";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   return $result;
}

function get_list_name($list_id, $lang) {
   global $dbconnect;
   $query = "SELECT name FROM liste WHERE list_id={$list_id}";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   $row = mysql_fetch_array($result);
   $list_name = decode($row["name"], $lang);
   return $list_name;
}


function get_rel_list_for_subj($subj_id) {
   global $dbconnect;
   $query = "SELECT rel_subj_list.list_id FROM rel_subj_list WHERE rel_subj_list.subj_id = {$subj_id}";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   $return = array();
   while ($row = mysql_fetch_array($result)) {
      $return[] = $row["list_id"];
   }
   return $return;
}

function get_list_for_subj($subj_id) {
   global $dbconnect;
   $query = "SELECT rel_subj_list.list_id, rel_subj_list.subj_id, liste.name, liste.desc FROM rel_subj_list, liste WHERE rel_subj_list.subj_id = {$subj_id} AND liste.list_id = rel_subj_list.list_id";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   return $result;
}

//////////////* legate de afisare chestionare */
function get_all_questionnaires () {
   global $dbconnect;
   $query = "SELECT * FROM questionnaires ORDER BY questionnaire_id ASC;";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   return $result;
}

function get_questionnaire($questionnaire_id ) {
   global $dbconnect;
   $query = "SELECT * FROM questionnaires WHERE questionnaire_id={$questionnaire_id}";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   return $result;
}

function get_questionnaire_name($questionnaire_id, $lang) {
   global $dbconnect;
   $query = "SELECT name FROM questionnaires WHERE questionnaire_id={$questionnaire_id}";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   $row = mysql_fetch_array($result);
   $questionnaire_name = decode($row["name"], $lang);
   return $questionnaire_name;
}

function get_ratings_for_questionnaire($questionnaire_id) {
   global $dbconnect;
   $query = "SELECT rating_id, min_val, max_val, scoring, value FROM ratings WHERE questionnaire_id = '".$questionnaire_id."' ORDER BY rating_id ASC;";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   return $result;
}


function get_question_name($question_id, $lang) {
   global $dbconnect;
   $query = "SELECT name FROM questions WHERE question_id={$question_id}";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   $row = mysql_fetch_array($result);
   $question_name = decode($row["name"], $lang);
   return $question_name;
}

function get_rel_questions_for_questionnaire($questionnaire_id) {
   global $dbconnect;
   $query = "SELECT question_id FROM questions WHERE questionnaire_id = '".$questionnaire_id."' ";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   $return = array();
   while ($row = mysql_fetch_array($result)) {
      $return[] = $row["question_id"];
   }
   return $return;
}


function get_questions_for_questionnaire($questionnaire_id) {
   global $dbconnect;
   $query = "SELECT question_id, name FROM questions WHERE questionnaire_id = '".$questionnaire_id."' ORDER BY question_id ASC;";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   return $result;
}



function get_choices_for_question($question_id) {
   global $dbconnect;
   $query = "SELECT choice_id, name, score FROM choices WHERE question_id = '".$question_id."' ORDER BY choice_id ASC;";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   return $result;
}

function get_questionnaire_for_question($question_id) {
   global $dbconnect;
   $query = "SELECT questionnaire_id FROM questions WHERE question_id = '".$question_id."';";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   $row = mysql_fetch_array($result);
   $qid = $row["questionnaire_id"];
   return $qid;
   //return $result;
}



//////////////* legate de afisare email */


function get_all_emails () {
   global $dbconnect;
   $query = "SELECT * FROM emails ORDER BY email_id ASC;";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   return $result;
}

function get_email($email_id) {
   global $dbconnect;
   $query = "SELECT * FROM emails WHERE email_id={$email_id}";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   return $result;
}

function get_rel_studies_for_email($email_id) {
   global $dbconnect;
   $query = "SELECT rel_studies_email.study_id FROM rel_studies_email WHERE rel_studies_email.email_id = {$email_id}";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   $return = array();
   while ($row = mysql_fetch_array($result)) {
      $return[] = $row["study_id"];
   }
   return $return;
}

function get_studies_for_email($email_id) {
   global $dbconnect;
   $query = "SELECT rel_studies_email.email_id, rel_studies_email.study_id, studies.name FROM rel_studies_email, studies WHERE rel_studies_email.email_id = {$email_id} AND studies.study_id = rel_studies_email.study_id";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   return $result;
}

/* legate de afisare studii */
function get_all_studies () {
   global $dbconnect;
   $query = "SELECT * FROM studies ORDER BY study_id ASC;";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   return $result;
}

function get_study($study_id) {
   global $dbconnect;
   $query = "SELECT * FROM studies WHERE study_id={$study_id}";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   return $result;
}


function get_study_name($study_id) {
   global $dbconnect;
   global $lang;

   $query = "SELECT `name` FROM studies WHERE study_id={$study_id}";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   $row = mysql_fetch_array($result);
   $study_name = decode($row["name"], $lang);
   return $study_name;
}


function get_sel_list_for_study($study_id) {
   global $dbconnect;
   $query = "SELECT rel_list_study.list_id FROM rel_list_study WHERE rel_list_study.study_id = {$study_id}";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   $return = array();
   while ($row = mysql_fetch_array($result)) {
      $return[] = $row["list_id"];
   }
   return $return;
}

function get_sel_quest_for_study($study_id) {
   global $dbconnect;
   $query = "SELECT rel_questionnaire_study.questionnaire_id FROM rel_questionnaire_study WHERE rel_questionnaire_study.study_id = {$study_id}";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   $return = array();
   while ($row = mysql_fetch_array($result)) {
      $return[] = $row["questionnaire_id"];
   }
   return $return;
}


function get_quest_for_study($study_id) {
   global $dbconnect;
   $query = "SELECT rel_questionnaire_study.study_id, rel_questionnaire_study.questionnaire_id, questionnaires.name FROM rel_questionnaire_study, questionnaires WHERE rel_questionnaire_study.study_id = {$study_id} AND questionnaires.questionnaire_id = rel_questionnaire_study.questionnaire_id";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   return $result;
}


function get_list_for_study($study_id) {
   global $dbconnect;
   $query = "SELECT rel_list_study.list_id, rel_list_study.study_id, liste.name FROM rel_list_study, liste WHERE rel_list_study.study_id = {$study_id} AND liste.list_id = rel_list_study.list_id";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   return $result;
}





?>
