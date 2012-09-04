<?php require_once("../includes/header.php") ?>

<?php
if(isset($_GET["list_id"])){
   $list_id = $_GET["list_id"];

   $result = get_list($list_id);
   $row = mysql_fetch_array($result);
      $list_id = $row["list_id"];
      $list_name_ro = decode($row["name"], "ro");
      $list_name_en = decode($row["name"], "en");
      $list_desc_ro = decode($row["desc"], "ro");
      $list_desc_en = decode($row["desc"], "en");
      $list_name = decode($row["name"], $lang);
      $list_desc = decode($row["desc"], $lang);
      $list_public = $row["public"];
   ?>

<!---
   Edit
--->

   <h1 class="lists"><?php __("Edit list")?> - <?php echo $list_name ?></h1>
   
   <form id="edit_list" action="procesare_liste.php" method="POST">
      <input class="required" type="hidden" name="action" value="edit"/>
      <input class="required" type="hidden" name="list_id" value="<?php echo $list_id ?>"/>

      <fieldset>
         <div class="ro">
            <label for="list_name_ro"><?php __("List Name (ro)") ?></label>
            <input class="required" name="list_name_ro" type="text" value="<?php echo $list_name_ro ?>" />
         </div>
         <div class="en">
            <label for="list_name_en"><?php __("List Name (en)") ?></label>
            <input class="required" name="list_name_en" type="text" value="<?php echo $list_name_en ?>" />
         </div>
      </fieldset>

      <fieldset>
         <div class="ro">
            <label for="list_desc"><?php __("Description (ro)") ?></label>
            <textarea class="required" name="list_desc_ro"><?php echo $list_desc_ro ?></textarea>
         </div>
         <div class="en">
            <label for="list_desc"><?php __("Description (en)") ?></label>
            <textarea class="required" name="list_desc_en"><?php echo $list_desc_en ?></textarea>
         </div>
      </fieldset>

      <fieldset>
         <label for="public"><?php __("Public") ?></label>
         <input type="radio" name="public[]" value="1" <?php if($list_public == 1) {echo "checked=\"checked\"" ; } ?> /> <?php __("Public list") ?><br />
         <input type="radio" name="public[]" value="0" <?php if($list_public == 0) {echo "checked=\"checked\"" ; } ?> /> <?php __("Private list") ?><br />
      </fieldset>

      <fieldset>
         <label for="subjects"><?php __("Subjects included in the list") ?></label>

         <?php
            $sel_subj = get_sel_subj_for_list($list_id);
            $all_subjects = get_all_subjects();
        
            while ($row = mysql_fetch_array($all_subjects)) {
               $subj_id = $row["subj_id"];
               $subj_first_name = $row["first_name"];
               $subj_last_name = $row["last_name"];
            ?>

            <input type="checkbox" <?php if (in_array($subj_id, $sel_subj)) {echo "checked=\"checked\"" ; } ?> name="subjects[]" value="<?php echo $subj_id ?> " /> <?php echo $subj_first_name." ". $subj_last_name ?><br />
         <?php 
         }
         ?>
      </fieldset>

      <div class="clear">
         <input name="submit" type="submit" value="<?php __("Save") ?> &raquo;" class="buton"/>
      </div>
   </form>

<?php
} else {
?>

   <h1 class="lists"><?php __("Add list") ?></h1>
   
   <form id="edit_list" action="procesare_liste.php" method="POST">
      <input type="hidden" name="action" value="add"/>

      <fieldset>
         <div class="ro">
            <label for="list_name_ro"><?php __("List Name (ro)") ?></label>
            <input class="required" name="list_name_ro" type="text" value="" />
         </div>
         <div class="en">
            <label for="list_name_en"><?php __("List Name (en)") ?></label>
            <input class="required" name="list_name_en" type="text" value="" />
         </div>
      </fieldset>

      <fieldset>
         <div class="ro">
            <label for="list_desc_ro"><?php __("Description (ro)") ?></label>
            <textarea class="required" name="list_desc_ro"></textarea>
         </div>
         <div class="en">
            <label for="list_desc_en"><?php __("Description (en)") ?></label>
            <textarea class="required" name="list_desc_en"></textarea>
         </div>
      </fieldset>

      <fieldset>
         <label for="public"><?php __("Public") ?></label>
         <input type="radio" name="public[]" value="1" checked="checked" /> <?php __("Public list") ?><br />
         <input type="radio" name="public[]" value="0" /> <?php __("Private list") ?><br />
      </fieldset>

      <fieldset>
         <label for="subjects"><?php __("Subjects included in the list") ?></label>

         <?php
            $all_subjects = get_all_subjects();
        
            while ($row = mysql_fetch_array($all_subjects)) {
               $subj_id = $row["subj_id"];
               $subj_first_name = $row["first_name"];
               $subj_last_name = $row["last_name"];
            ?>

            <input type="checkbox" name="subjects[]" value="<?php echo $subj_id ?> " /> <?php echo $subj_first_name." ". $subj_last_name ?><br />
         <?php 
         }
         ?>
      </fieldset>

      <div class="clear">
         <input name="submit" type="submit" value="<?php __("Send") ?> &raquo;" class="buton"/>
      </div>
   </form>

<?php
}
?>
   
<?php require_once("../includes/footer.php") ?>