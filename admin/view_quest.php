<?php require_once("../includes/header.php") ?>
<?php $_utils = new Utils() ?>

<?php

if(isset($_GET["questionnaire_id"])){

   $questionnaire_id= $_GET["questionnaire_id"];

   $result = get_questionnaire($questionnaire_id);
   $row = mysql_fetch_array($result);
      $questionnaire_id = $row["questionnaire_id"];
      $questionnaire_name = decode($row["name"], $lang);
      $questionnaire_desc = decode($row["desc"], $lang);
      $display_type = $row["display_type"];
      $quest_type = $row["quest_type"];
      $max_score = $row["max_score"];

   ?>
   <h1 class="quest"><?php echo $questionnaire_name ?></h1>
   
   <div id="list_details">
   <?php output_message() ?>

      <p><strong><?php __("Questionnaire Name") ?>:</strong> <?php echo $questionnaire_name ?></p>
      <p><strong><?php __("Description") ?>:</strong> <?php echo $questionnaire_desc ?></p>
      <p><strong><?php __("Maximum score") ?>:</strong> <?php echo $max_score ?></p>
      <p><strong><?php __("Display type") ?>:</strong> <?php echo $display_type ?></p>
      <p><strong><?php __("Questionnaire type") ?>:</strong> <?php echo $quest_type ?></p>

      <p><strong><?php __("Questions") ?>:</strong></p>
      <ul>

            <li class="head">
               <ul class="grid">
                  <li class="title"><?php __('Question') ?></li>
                  <li class="question_type"><?php __('Question Type') ?></li>
                  <li class="questionnaire_name"><?php __('Choices') ?></li>
               </ul>
            </li>


         <?php
            $result = get_questions_for_questionnaire($questionnaire_id);
            while ($row = mysql_fetch_array($result)) {
                  $question_id = $row["question_id"];
                  $question_type = $row["type"];
                  $question_name = decode($row["name"], $lang);
            ?>
            <li>
               <ul class="grid">

                  <li class="title"><em><?php echo $question_name ?></em></li>
                  <li class="question_type"><?php echo $question_type; ?></li>
                  <li class="choices">
                     <?php if($question_type == "choice"): ?>
                     <?php
                        $result_choice = get_choices_for_question($question_id);
                        $choice_count = mysql_num_rows($result_choice);
                        if($choice_count > 0):  ?>
                        <ul>
                           <?php
                                 while ($row = mysql_fetch_array($result_choice)) {
                                 $choice_name = decode($row["name"], $lang);
                                 $choice_score = $row["score"];
                                 ?>
                                 <li><?php echo $choice_score . " - " . $choice_name ?></li>
                                 <?php
                              }
                           ?>
                        </ul>
                        <?php else: ?>
                        <?php __('No choice has been defined yet') ?>
                        <?php endif; ?>
                     <?php endif; ?>
                  </li>
               </ul>
            </li>
            <?php
            }
         ?>
      </ul>
      
      <p><strong><?php __("Ratings") ?>:</strong></p>
         <ul>
         <?php
            $result = get_ratings_for_questionnaire($questionnaire_id);
            while ($row = mysql_fetch_array($result)) {

                  $rating_id = $row["rating_id"];
                  $rating_min_val = $row["min_val"];
                  $rating_max_val = $row["max_val"];
                  $rating_scoring = $row["scoring"];
         ?>
            <li>Min. val.: <?php echo $rating_min_val ?> / Max. val.: <?php echo $rating_max_val ?> / Scoring: <?php echo $rating_scoring ?></li>
         <?php
            }
         ?>
         </ul>

      <p><a href="edit_quest.php?questionnaire_id=<?php echo $questionnaire_id ?>"><?php __("Edit questionnaire") ?></a></p>      
   </div>

<?php
} else {
   $_utils->_redirect("manage_questionnaires.php");
}
?>

<?php require_once("../includes/footer.php") ?>
