<?php require_once("../includes/header.php") ?>

<?php
if(isset($_GET["questionnaire_id"])){
   $questionnaire_id = $_GET["questionnaire_id"];

   $result = get_questionnaire($questionnaire_id);
   $row = mysql_fetch_array($result);
      $questionnaire_name_ro = decode($row["name"], "ro");
      $questionnaire_name_en = decode($row["name"], "en");
      $questionnaire_desc_ro = decode($row["desc"], "ro");
      $questionnaire_desc_en = decode($row["desc"], "en");
      $questionnaire_name = decode($row["name"], $lang);
      $display_type = $row["display_type"];
      $quest_type = $row["quest_type"];
      $max_score = $row["max_score"];
?>

<!-- edit questionnnaire -->

   <h1 class="quest"><?php __("Edit Questionnaire")?> - <?php echo $questionnaire_name ?></h1>
   
   <form id="questionnaire" class="questionnaire" action="process_quest.php" method="POST">
      <input type="hidden" name="action" value="edit"/>
      <input type="hidden" name="questionnaire_id" value="<?php echo $questionnaire_id ?>" />
   
      <fieldset class="title">
         <div class="ro">
            <label for="quest_title_ro"><?php __("Questionnaire title (ro)") ?></label>
            <input class="required" name="quest_title_ro" type="text" value="<?php echo $questionnaire_name_ro ?>" />
         </div>
         <div class="en">
            <label for="quest_title_en"><?php __("Questionnaire title (en)") ?></label>
            <input class="required" name="quest_title_en" type="text" value="<?php echo $questionnaire_name_en ?>" />
         </div>
      </fieldset>   
   
      <fieldset class="description">
         <div class="ro">
            <label for="quest_desc_ro"><?php __("Description (ro)") ?></label>
            <textarea class="required" name="quest_desc_ro"><?php echo $questionnaire_desc_ro ?></textarea>
         </div>
         <div class="en">
            <label for="quest_desc_en"><?php __("Description (en)") ?></label>
            <textarea class="required" name="quest_desc_en"><?php echo $questionnaire_desc_en ?></textarea>
         </div>
      </fieldset>
   
      <fieldset class="inline">
            <label class="inline" for="quest_max_score"><?php __("Maximum score") ?></label>
            <input class="required" class="inline" name="quest_max_score" type="text" value="<?php echo $max_score ?>" />
      </fieldset>


      <div class="questions_section">

      <div class="question">
      
      <?php
         $result_questions = get_questions_for_questionnaire($questionnaire_id);
         $index_q = 0;
         while ($row = mysql_fetch_array($result_questions)) {
            $question_id = $row["question_id"];
            $question_type = $row["type"];
            $question_name_ro = decode($row["name"], "ro");
            $question_name_en = decode($row["name"], "en");
            $index_q++;
         ?>
   
            <div id="question_<?php echo $index_q ?>" class="question item">
   
               <h3><?php __("Question no.") ?> <span class="number"><?php echo $index_q ?></span></h3>
               <input type="hidden" class="question_id" name="question_id_<?php echo $index_q ?>" value="<?php echo $question_id ?>" />
               <fieldset class="title">
                  <div class="ro">
                     <label for="question_<?php echo $index_q ?>_ro"><?php __("Question (ro)") ?></label>
                     <input class="required" name="question_<?php echo $index_q ?>_ro" type="text" value="<?php echo $question_name_ro ?>" />
                  </div>
                  <div class="en">
                     <label for="question_<?php echo $index_q ?>_en"><?php __("Question (en)") ?></label>
                     <input class="required" name="question_<?php echo $index_q ?>_en" type="text" value="<?php echo $question_name_en ?>" />
                  </div>
               </fieldset>
               <select name="question_<?php echo $index_q ?>_type" onchange="toggle_question_type(this)" >
                  <option value="text" <?php if($question_type == 'text'): ?> selected <?php endif; ?>><?php __('text field') ?></option>
                  <option value="choice" <?php if($question_type == 'choice'): ?> selected <?php endif; ?>><?php __('choice') ?></option>
               </select>
      
               <div class="choice">
   
                  <?php
                     $result_choices = get_choices_for_question($question_id);
                     $index_c = 0;
                     $a = array('Acord puternic', 'Intrucatva de acord','Dezacord partial','Dezacord puternic','-');
                     while ($row = mysql_fetch_array($result_choices)) {
                        $choice_id = $row["choice_id"];
                        $choice_name_ro = decode($row["name"], "ro");
                        $choice_name_en = decode($row["name"], "en");
                        $choice_score = $row["score"];
                        $index_c++;
                  ?>
   
                  <div id="question_<?php echo $index_q ?>_choice_<?php echo $index_c ?>" class="choice item">
                  <input type="hidden" name="question_<?php echo $index_q ?>_choice_<?php echo $index_c ?>_id" value="<?php echo $choice_id ?>" />
                     <fieldset class="title">
                        <div class="ro">
                           <label for="question_<?php echo $index_q ?>_choice_<?php echo $index_c ?>_ro"><?php __("Choice") ?> <span class="number"><?php echo $index_c ?></span> (ro)</label>
                           <input class="required" name="question_<?php echo $index_q ?>_choice_<?php echo $index_c ?>_ro" type="text" value="<?php echo $choice_name_ro ?>" />
                        </div>
                           <div class="en">
                              <label for="question_<?php echo $index_q ?>_choice_<?php echo $index_c ?>_en"><?php __("Choice") ?> <span class="number"><?php echo $index_c ?></span> (en)</label>
                              <input class="required" name="question_<?php echo $index_q ?>_choice_<?php echo $index_c ?>_en" type="text" value="<?php echo $choice_name_en ?>" />
                           </div>
                     </fieldset>
                     <fieldset class="inline score">
                        <label class="clear" for="question_<?php echo $index_q ?>_choice_<?php echo $index_c ?>_score"><?php __("Score") ?></label>
                        <input class="required" class="inline" name="question_<?php echo $index_q ?>_choice_<?php echo $index_c ?>_score" type="text" value="<?php echo $choice_score ?>" />
                     </fieldset>
                  </div><!-- end div choice.item -->
                  <?php
                     }
                  ?>
               </div><!-- end div.choices -->
      <div class="controls" <?php if($question_type == 'text'): ?> style="display:none;" <?php endif; ?>>
         <a class="add_choice"		href="add_choice"		onclick="add_choice(this);		return false;">[ + ] <?php __("Add answer choice ") ?></a>
         <br />
         <a class="delete_choice" href="delete_choice"	onclick="delete_choice(this);	return false;">[ + ] <?php __("Remove choice ") ?></a>
         <input type="hidden" name="number_of_choices_q<?php echo $index_q ?>" value="<?php echo $index_c ?>">
      </div>

            </div><!-- end div.question.item-->
      <?php
         }
      ?>
      
      </div><!-- end div .questions -->
      <div class="controls">
         <a class="add_question"    href="add_question"     onclick="add_question(this); return false;">[ + ] <?php __("Add question") ?></a>
         <br />
         <a class="delete_question" href="delete_question"  onclick="delete_question(this); return false;">[ - ] <?php __("Delete question") ?></a>
         <input type="hidden" name="number_of_questions" value="<?php echo $index_q ?>">
      </div>

      </div>
   
      <div class="rating">
            <h2><?php __("Rating grid") ?></h2>
   
            <ul>
            <?php
               $result = get_ratings_for_questionnaire($questionnaire_id);
               $index_r = 0;
               while ($row = mysql_fetch_array($result)) {
                     $rating_id = $row["rating_id"];
                     $rating_min_val = $row["min_val"];
                     $rating_max_val = $row["max_val"];
                     $rating_scoring = $row["scoring"];
                     $rating_value = $row["value"];
                     $index_r++;
               ?>
   
               <input type="hidden" name="rating_id_<?php echo $index_r ?>" value="<?php echo $rating_id ?>"/> 
               <fieldset class="inline">
                     <label class="inline min" for="min_val_<?php echo $index_r ?>"><?php __("Minimum value") ?></label>
                     <input class="required inline min" name="min_val_<?php echo $index_r ?>" type="text" value="<?php echo $rating_min_val ?>" />
                     <label class="inline max" for="max_val_<?php echo $index_r ?>"><?php __("Maximum value") ?></label>
                     <input class="required inline max" name="max_val_<?php echo $index_r ?>" type="text" value="<?php echo $rating_max_val ?>" />
                     <label class="inline" for="scoring_<?php echo $index_r ?>"><?php __("Scoring") ?></label>
                     <input class="required inline" name="scoring_<?php echo $index_r ?>" type="text" value="<?php echo $rating_scoring ?>" />
                     <label class="inline" for="value_<?php echo $index_r ?>"><?php __("Value") ?></label>
                     <input class="required inline" name="value_<?php echo $index_r ?>" type="text" value="<?php echo $rating_value ?>" />
               </fieldset>
               <?php
               }
            ?>
            </ul>
   
      </div><!-- end div .rating_grid -->
   
      <fieldset>
         <label for="display_type"><?php __("Display type") ?>:</label>
            <input type="radio" name="display_type" value="normal" <?php if($display_type == "normal"): ?>checked<?php endif ?> /> <?php __("normal") ?>
            <input type="radio" name="display_type" value="radial" <?php if($display_type == "radial"): ?>checked<?php endif ?> /> <?php __("radial") ?>
      </fieldset>
   
      <fieldset>
         <label for="quest_type"><?php __("Questionnaire type") ?>:</label>
            <input type="radio" name="quest_type" value="normal" <?php if($quest_type == "normal"): ?>checked<?php endif ?> /> <?php __("normal") ?>
            <input type="radio" name="quest_type" value="360" <?php if($quest_type == "360"): ?>checked<?php endif ?> /> <?php __("360") ?>
      </fieldset>

      <div class="clear">
         <input name="submit" type="submit" value="<?php __("Save") ?> &raquo;" class="buton"/>
      </div>
   </form>
     
   <?
   } else { /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   ?>



<!-- ADD questionnnaire -->

   <h1 class="quest"><?php __("Add Questionnaire") ?></h1>
   
   <form id="questionnaire" class="questionnaire" action="process_quest.php" method="POST">
      <input type="hidden" name="action" value="add"/>
   
      <fieldset class="title">
         <div class="ro">
            <label for="quest_title_ro"><?php __("Questionnaire title (ro)") ?></label>
            <input class="required" name="quest_title_ro" type="text" value="" />
         </div>
         <div class="en">
            <label for="quest_title_en"><?php __("Questionnaire title (en)") ?></label>
            <input class="required" name="quest_title_en" type="text" value="" />
         </div>
      </fieldset>
   
      <fieldset class="description">
         <div class="ro">
            <label for="quest_desc_ro"><?php __("Description (ro)") ?></label>
            <textarea class="required" name="quest_desc_ro"></textarea>
         </div>
         <div class="en">
            <label for="quest_desc_en"><?php __("Description (en)") ?></label>
            <textarea class="required" name="quest_desc_en"></textarea>
         </div>
      </fieldset>
   
      <fieldset class="inline">
            <label class="inline" for="quest_max_score"><?php __("Maximum score") ?></label>
            <input class="required" class="inline" name="quest_max_score" type="text" value="" />
      </fieldset>
      

      <div class="questions_section">
         <div class="question"></div>
         <div class="controls">
            <a class="add_question"    href="add_question"     onclick="add_question(this); return false;">[ + ] <?php __("Add question") ?></a>
            <br />
            <a class="delete_question" href="delete_question"  onclick="delete_question(this); return false;">[ - ] <?php __("Delete question") ?></a>
            <input type="hidden" name="number_of_questions" value="0">
         </div>
      </div>


      <div class="rating">
         <h2><?php __("Rating grid") ?></h2>
         <?php
            for($index_r = 1; $index_r <= 5; $index_r++){
            ?>
            <fieldset class="inline">
               <label class="inline min" for="min_val_<?php echo $index_r ?>"><?php __("Minimum value") ?></label>
               <input class="required inline min" name="min_val_<?php echo $index_r ?>" type="text" value="" />
               <label class="inline max" for="max_val_<?php echo $index_r ?>"><?php __("Maximum value") ?></label>
               <input class="required inline max" name="max_val_<?php echo $index_r ?>" type="text" value="" />
               <label class="inline" for="scoring_<?php echo $index_r ?>"><?php __("Scoring") ?></label>
               <input class="required inline" name="scoring_<?php echo $index_r ?>" type="text" value="" />
               <label class="inline" for="value_<?php echo $index_r ?>"><?php __("Value") ?></label>
               <input class="required inline" name="value_<?php echo $index_r ?>" type="text" value="" />
            </fieldset>
            <?php
            }
         ?>
      </div><!-- end div .rating_grid -->
   
      <fieldset>
         <label for="display_type"><?php __("Display type") ?>:</label>
            <input type="radio" name="display_type" value="normal" checked /> <?php __("normal") ?>
            <input type="radio" name="display_type" value="radial" /> <?php __("radial") ?>
      </fieldset>
   
      <fieldset>
         <label for="quest_type"><?php __("Questionnaire type") ?>:</label>
            <input type="radio" name="quest_type" value="normal" checked /> <?php __("normal") ?>
            <input type="radio" name="quest_type" value="360" /> <?php __("360") ?>
      </fieldset>
      

      <div class="clear">
         <input name="submit" type="submit" value="<?php __("Send") ?> &raquo;" class="buton"/>
      </div>
   </form>
   
   <?php
   }
   ?>
   
<?php require_once("../includes/footer.php") ?>
