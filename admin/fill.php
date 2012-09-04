<?php require_once("../includes/header.php") ?>

<?php
   if(isset($_POST["submit"])) {
      unset($_POST["submit"]);
      $post_subject_id = $_POST["subject_id"];
      $post_study_id = $_POST["study_id"];
      unset($_POST["subject_id"]);
      unset($_POST["study_id"]);

      foreach($_POST as $question_id => $choice_id) {
         
         $check = "SELECT * FROM results WHERE study_id = ".$post_study_id." AND subj_id = ".$post_subject_id." AND question_id = ".$question_id;
         $result = mysql_query($check, $dbconnect);
         
         if(mysql_num_rows($result) == 0){
            $query = "INSERT INTO results (`study_id`, `subj_id`, `question_id`, `choice_id`)
                                 VALUES ('".$post_study_id."',  '".$post_subject_id."', '".$question_id."', '".$choice_id."') ";
            $result = mysql_query($query, $dbconnect);
            confirm_query($result);
         } else {
         }
      }
      
      redirect("view_subject.php?subj_id=".$post_subject_id);
   }
?>


<?php
   if(isset($_GET["subj"])) {
      $subject_id = $_GET["subj"];
   } else {
      //redirect("index.php");
   }

   if(isset($_GET["study"])) {
      $study_id = $_GET["study"];
   } else {
      //redirect("index.php");
   }

?>

      <?php
         $result = get_quest_for_study($study_id);
         while ($row = mysql_fetch_array($result)) {
            $questionnaire_ids[] = $row["questionnaire_id"];
         }
      ?>

   <div id="list_details">
      <form id="" action="fill.php" method="post">
         <input type="hidden" name="subject_id" value="<?php echo $subject_id ?>" />
         <input type="hidden" name="study_id" value="<?php echo $study_id ?>" />

         <?php
            foreach($questionnaire_ids as $questionnaire_id) {
            
               $result = get_questionnaire($questionnaire_id);
               $row = mysql_fetch_array($result);
                  $questionnaire_id = $row["questionnaire_id"];
                  $questionnaire_name = decode($row["name"], $lang);
                  $questionnaire_desc = decode($row["desc"], $lang);
                  $display_type = $row["display_type"];
                  $quest_type = $row["quest_type"];
                  $max_score = $row["max_score"];
         ?>

   
         <h2><strong><?php echo $questionnaire_name ?></strong></h2>
         <!--
         <p><strong><?php __("Maximum score") ?>:</strong> <?php echo $max_score ?></p>
         <p><strong><?php __("Display type") ?>:</strong> <?php echo $display_type ?></p>
         -->
         <ul>
            <?php
               $result = get_questions_for_questionnaire($questionnaire_id);
               while ($row = mysql_fetch_array($result)) {
                     $question_id = $row["question_id"];
                     $question_name = decode($row["name"], $lang);
               ?>
               <li>
                     <p><strong><em><?php echo $question_name ?></em></strong></p>
                        <?php
                           $result_choice = get_choices_for_question($question_id);
                           while ($row = mysql_fetch_array($result_choice)) {
                              $choice_name = decode($row["name"], $lang);
                              $choice_score = $row["score"];
                        ?>
                        <input type="radio" name="<?php echo $question_id ?>" value="<?php echo $choice_score ?>" /><?php echo $choice_name ?><br />
                        <?php
                           }
                        ?>
               </li>
               <?php
               }
            ?>
         </ul>

         <?php } ?>  

         
         <div class="clear">
            <input name="submit" type="submit" value="<?php __("Send") ?> &raquo;" class="buton"/>
         </div>      
      </form>
   </div>



<?php require_once("../includes/footer.php") ?>
