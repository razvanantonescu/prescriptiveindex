<?php require_once("../includes/header.php") ?>

<?php
if(isset($_GET["subj_id"])){
   $subj_id = $_GET["subj_id"];

   $result = get_subject($subj_id);
   $row = mysql_fetch_array($result);
      $subj_id = $row["subj_id"];
      $subj_first_name = $row["first_name"];
      $subj_last_name = $row["last_name"];
      $subj_gender = $row["gender"];
      $subj_bdate = $row["birth_date"];
      $subj_email = $row["email"];
      $subj_tested = $row["tested"];
      $subj_status = $row["status"];
   ?>

   <h1 class="subjects"><?php echo $subj_first_name ." ". $subj_last_name ?></h1>
   
   <div id="list_details">
   <?php output_message() ?>

      <p><strong><?php __("First Name") ?>:</strong> <?php echo $subj_first_name ?></p>
      <p><strong><?php __("Last Name") ?>:</strong> <?php echo $subj_last_name ?></p>
      <p><strong><?php __("Gender") ?>:</strong> <?php echo $subj_gender ?></p>
      <p><strong><?php __("Date of Birth") ?>:</strong> <?php echo $subj_bdate ?></p>
      <p><strong><?php __("Email") ?>:</strong> <?php echo $subj_email ?></p>
      <p><strong><?php __("Tested") ?>:</strong> <?php if($subj_tested == '1'){__("tested");} else {__("not tested");} ?></p>
      <p><strong><?php __("Status") ?>:</strong> <?php if($subj_status == '1'){__("approved");} else {__("pending");} ?></p>
      <p><strong><?php __("Lists") ?>:</strong></p>
      <ul>
         <?php
            $lists = get_list_for_subj($subj_id);
            while ($row = mysql_fetch_array($lists)) {
                  $list_id = $row["list_id"];
                  $list_name = decode($row["name"], $lang);
         ?>
         <li><a href="view_list.php?list_id=<?php echo $list_id ?>"><?php echo $list_name ?></a></li>
         <?php
            }
         ?>
      </ul>

      <p><strong>Studii la care a raspuns:</strong></p>
      <ul>
         <?php
		  $query = "SELECT study_id FROM results WHERE subj_id=".$subj_id;
		  //echo $query;
		  $result = mysql_query($query, $dbconnect);
		  confirm_query($result);
		  while($row = mysql_fetch_array($result)) {
			$study_ids[] = $row["study_id"];
		  }
		  if(!empty($study_ids)) {
			$study_ids = array_unique($study_ids);
			foreach($study_ids as $study_id) {
			   $result = get_study($study_id);
			   $row = mysql_fetch_array($result);
			   $study_id = $row["study_id"];
			   $study_name = decode($row["name"], $lang);
			   $query = "
select
  questionnaires.name as name,
  questionnaires.questionnaire_id as id
from
  questionnaires,
  rel_questionnaire_study
where
  rel_questionnaire_study.study_id = ".$study_id."
  and rel_questionnaire_study.questionnaire_id = questionnaires.questionnaire_id
			   ";
			   $result = mysql_query($query, $dbconnect);
			   $quest = array();
			   while($row = mysql_fetch_array($result))
			   {
			     $quest[] = array($row['name'], $row['id']);
			   }
	    ?>
				<li>
				 <a href="view_study.php?study_id=<?php echo $study_id ?>"><?php echo $study_name ?></a> - 
				 <a href="view_results.php?study_id=<?php echo $study_id ?>&subj_id=<?php echo $subj_id ?>"><?php __('answers') ?></a>
				 <?php
				   foreach ($quest as $q)
				   {
				     $qname = json_decode($q[0]);
                                 ?>
                                 <br><a style='padding-left:20px' href="view_scoring.php?study_id=<?php echo $study_id ?>&quest_id=<?php echo $q[1] ?>&subj_id=<?php echo $subj_id ?>"><?php __('Scoring '); echo " ".($_SESSION['lang'] == 'ro' ? $qname->ro : $qname->en); ?></a> - <a href="view_raport.php?study_id=<?php echo $study_id ?>&quest_id=<?php echo $q[1] ?>&subj_id=<?php echo $subj_id ?>"><?php __('Raport '); echo " ".($_SESSION['lang'] == 'ro' ? $qname->ro : $qname->en); ?></a>
                                 <?php
				   }
				 ?>
				</li>
	    <?php
			}
		  } else {
			__("No study attended by this subject yet.") ;
		  }
         ?>
      </ul>

      <p><a href="edit_subject.php?subj_id=<?php echo $subj_id ?>"><?php __("Edit subject") ?></a></p>
      <p><a href="process_subject.php?subj_id=<?php echo $subj_id ?>&action=delete"><?php __("Delete subject") ?></a></p>
  
   </div>

<?php
} else {
   redirect("manage_subjects.php");
}
?>
<?php require_once("../includes/footer.php") ?>