<?php require_once("../includes/header.php") ?>
<?php $_utils = new Utils() ?>

<?php
if(isset($_GET["study_id"])){ /////////////////////////////// EDIT STUDY
   $study_id = $_GET["study_id"];

   $result = get_study($study_id);
   $row = mysql_fetch_array($result);
      $study_id = $row["study_id"];
      $study_name_ro = stripslashes(decode($row["name"], "ro"));
      $study_name_en = stripslashes(decode($row["name"], "en"));
      $study_desc_ro = stripslashes(decode($row["desc"], "ro"));
      $study_desc_en = stripslashes(decode($row["desc"], "en"));
      $study_name = stripslashes(decode($row["name"], $lang));
      $study_desc = stripslashes(decode($row["desc"], $lang));
      $study_type = $row["study_type"];
   ?>

   <h1 class="studies"><?php __("Edit study") ?> - <?php echo $study_name ?></h1>
   
   <form id="edit_study" action="process_studies.php" method="POST">
      <input type="hidden" name="study_id" value="<?php echo $study_id ?>"/>
      <input type="hidden" name="action" value="edit"/>

      <fieldset>
         <div class="ro">
            <label for="study_name_ro"><?php __("Study Name (ro)") ?></label>
            <input class="required" name="study_name_ro" type="text" value="<?php echo $study_name_ro ?>" />
         </div>
         <div class="en">
            <label for="study_name_en"><?php __("Study Name (en)") ?></label>
            <input class="required" name="study_name_en" type="text" value="<?php echo $study_name_en ?>" />
         </div>
      </fieldset>

      <fieldset>
         <div class="ro">
            <label for="study_desc"><?php __("Description (ro)") ?></label>
            <textarea class="required" name="study_desc_ro"><?php echo $study_desc_ro ?></textarea>
         </div>
         <div class="en">
            <label for="study_desc"><?php __("Description (en)") ?></label>
            <textarea class="required" name="study_desc_en"><?php echo $study_desc_en ?></textarea>
         </div>
      </fieldset>

   
      <fieldset>
         <label for="study_type"><?php __("Study type") ?>:</label>
            <input type="radio" name="study_type" value="normal" <?php if($study_type == "normal"): ?>checked<?php endif ?> /> <?php __("normal") ?>
            <input type="radio" name="study_type" value="360" <?php if($study_type == "360"): ?>checked<?php endif ?> /> <?php __("360") ?>
      </fieldset>

      <fieldset>
         <label for="questionnaires"><?php __("Questionnaires included in this study") ?>:</label>
         <?php
            $sel_questionnaires = get_sel_quest_for_study($study_id);
            $questionnaires = get_all_questionnaires();
        
            while ($row = mysql_fetch_array($questionnaires)) {
               $questionnaire_id = $row["questionnaire_id"];
               $questionnaire_name = stripslashes(decode($row["name"], $lang));
         ?>
            <input type="checkbox" <?php if (in_array($questionnaire_id, $sel_questionnaires)) {echo "checked=\"checked\"" ; } ?> name="questionnaires[]" value="<?php echo $questionnaire_id ?> " /> <?php echo $questionnaire_name ?><br />
         <?php 
            }
         ?>
      </fieldset>

      <fieldset>
         <label for="list"><?php __("The study applies to the following lists") ?>:</label>
         <?php
            $sel_list = get_sel_list_for_study($study_id);
            $lists = get_all_lists();
        
            while ($row = mysql_fetch_array($lists)) {
               $list_id = $row["list_id"];
               $list_name = stripslashes(decode($row["name"], $lang));
         ?>
            <input type="checkbox" <?php if (in_array($list_id, $sel_list)) {echo "checked=\"checked\"" ; } ?> name="list[]" value="<?php echo $list_id ?> " /> <?php echo $list_name ?><br />
         <?php 
            }
         ?>
      </fieldset>

      <fieldset>
         <label for="email_template"><?php __("Use as email template") ?>:</label>
            <?php
         		$rel_template = get_rel_template_id_for_study($study_id);
               $all_templates = get_all_templates();

               while ($row = mysql_fetch_array($all_templates)) {
                  $template_id = $row["email_id"];
                  $template_name = decode($row["name"], $lang);
            ?>
<input type="radio" name="email_template" value="<?php echo $template_id; ?>" <?php if($rel_template == $template_id) echo "checked" ?> /><?php echo $template_name ?><br />
            <?php 
               }
            ?>
      </fieldset>

      <div class="clear">
         <input name="submit" type="submit" value="<?php __("Save") ?>  &raquo;" class="buton"/>
      </div>
   </form>

<?php
} else { ///////////////////////////////////////////////// ADD STUDY
?>

   <h1 class="studies"><?php __("Add study") ?></h1>
   
   <form id="add_study" action="process_studies.php" method="POST">
      <input type="hidden" name="action" value="add"/>

      <fieldset>
         <div class="ro">
            <label for="study_name_ro"><?php __("Study Name (ro)") ?></label>
            <input class="required" name="study_name_ro" type="text" value="" />
         </div>
         <div class="en">
            <label for="study_name_en"><?php __("Study Name (en)") ?></label>
            <input class="required" name="study_name_en" type="text" value="" />
         </div>
      </fieldset>

      <fieldset>
         <div class="ro">
            <label for="study_desc_ro"><?php __("Description (ro)") ?></label>
            <textarea class="required" name="study_desc_ro"></textarea>
         </div>
         <div class="en">
            <label for="study_desc_en"><?php __("Description (en)") ?></label>
            <textarea class="required" name="study_desc_en"></textarea>
         </div>
      </fieldset>

      <fieldset>
         <label for="study_type"><?php __("Questionnaire type") ?>:</label>
            <input type="radio" name="study_type" value="normal" checked /> <?php __("normal") ?>
            <input type="radio" name="study_type" value="360" /> <?php __("360") ?>
      </fieldset>

      <fieldset>
         <label for="questionnaires"><?php __("Questionnaires included in this study") ?>:</label>
         <?php
            $result = get_all_questionnaires ();
            while ($row = mysql_fetch_array($result)) {
               $questionnaire_id = $row["questionnaire_id"];
               $questionnaire_name = stripslashes(decode($row["name"], $lang));
            ?>
            <input type="checkbox" name="questionnaires[]" value="<?php echo $questionnaire_id ?> " /> <?php echo $questionnaire_name ?><br />
         <?php 
         }
         ?>
      </fieldset>

      <fieldset>
         <label for="list"><?php __("The study applies to the following lists") ?>:</label>
         <?php
            $result = get_all_lists();
            while ($row = mysql_fetch_array($result)) {
               $list_id = $row["list_id"];
               $list_name = stripslashes(decode($row["name"], $lang));
         ?>
            <input type="checkbox" name="list[]" value="<?php echo $list_id ?> " /> <?php echo $list_name?><br />
         <?php 
            }
         ?>
      </fieldset>

      <fieldset>
         <label for="email_template"><?php __("Use as email template") ?>:</label>
            <?php
               $all_templates = get_all_templates();
               while ($row = mysql_fetch_array($all_templates)) {
                  $template_id = $row["email_id"];
                  $template_name = decode($row["name"], $lang);
            ?>
            <input type="radio" name="email_template" value="<?php echo $template_id; ?>" /><?php echo $template_name ?><br />
            <?php 
               }
            ?>
      </fieldset>

      <div class="clear">
         <input name="submit" type="submit" value="<?php __("Send") ?>  &raquo;" class="buton"/>
      </div>
   </form>
<?php
}
?>


   
<?php require_once("../includes/footer.php") ?>
