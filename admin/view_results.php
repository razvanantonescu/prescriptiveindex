<?php require_once("../includes/header.php") ?>

<?php
if(isset($_GET["study_id"]) && isset($_GET["subj_id"])){
   $study_id = $_GET["study_id"];
   $subject_id = $_GET["subj_id"];
   $subject_name = get_subj_name($subject_id);
   $study_name = get_study_name($study_id);

?>   

   <h1 class="quest"><?php __("Answers")?> - <?php echo $study_name ?></h1>
   <p><strong><?php __("Subject name: ") ?></strong><?php echo $subject_name; ?></p>  

   <div id="list_details">
      <ul>

            <li class="head">
               <ul class="grid">
                  <li class="title"><?php __('Question') ?></li>
                  <li class="questionnaire_name"><?php __('Questionnaire Name') ?></li>
                  <li class="question_type"><?php __('Question Type') ?></li>
                  <li class="answer"><?php __('Answer') ?></li>
                  <li class="score"><?php __('Score') ?></li>
               </ul>
            </li>


      <?php
         $query = "SELECT * FROM results WHERE results.subj_id = ".$subject_id." AND results.study_id = ".$study_id;
         $result = mysql_query($query, $dbconnect);
         while($row = mysql_fetch_array($result)){
            $question_name = get_question_name($row['question_id'], $lang);
            $question_type = get_question_type($row['question_id']);
            $questionnaire_name = get_questionnaire_name($row['questionnaire_id'], $lang);
      ?>
            <li>
               <ul class="grid">
                  <li class="title">
                     <?php echo $question_name ?>
                  </li>
                  <li class="questionnaire_name">
                     <?php echo $questionnaire_name ?>
                  </li>
                  <li class="question_type">
                     <?php echo $question_type ?>
                  </li>
                  <li class="answer">
                     <?php
                        if($row['choice_id'] == 0) {
                           echo $row['data'];
                        } else {
                           echo get_choice_name($row['choice_id'], $lang);
                        }
                     ?>
                  </li>
                  <li class="score">
                     <?php
                        if($row['choice_id'] != 0) {
                           echo get_choice_score($row['choice_id']);
                        }
                     ?>
                  </li>
               </ul>
            </li>
      <?php
         }
} else {
   redirect("manage_subjects.php");
}
?>
      </ul>
      
      <a class="download csv" href="csv.php?subj_id=<?php echo $subject_id ?>&study_id=<?php echo $study_id ?>" title="<?php __('Descarcă în format .csv') ?>"><?php __('Download in csv format') ?></a>
      
   </div><!-- list details -->
<?php require_once("../includes/footer.php") ?>