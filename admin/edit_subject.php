<?php require_once("../includes/header.php") ?>
<?php $_utils = new Utils() ?>

<?php
if(isset($_GET["subj_id"])){
   $subj_id = $_GET["subj_id"];

   $result = get_subject($subj_id);
   $row = mysql_fetch_array($result);
      $subj_id = $row["subj_id"];
      $subj_first_name = $row["first_name"];
      $subj_last_name = $row["last_name"];
      $subj_gender = $row["gender"];
      $subj_email = $row["email"];
      $subj_status = $row["status"];
   ?>

   <h1 class="subjects">Edit subject <em><?php echo $subj_first_name ." ". $subj_last_name ?> <em></h1>
   
   <form id="edit_subj" action="process_subject.php" method="POST">
      <input type="hidden" name="subj_id" value="<?php echo $subj_id ?>"/>
      <input type="hidden" name="action" value="edit"/>

      <div class="ro">
         <fieldset>
            <label for="subj_first_name"><?php __("First Name") ?>:</label>
            <input class="required" name="subj_first_name" type="text" value="<?php echo $subj_first_name ?>" />
            
            <label for="subj_last_name"><?php __("Last Name") ?>:</label>
            <input class="required" name="subj_last_name" type="text" value="<?php echo $subj_last_name ?>" />
         </fieldset>
         <fieldset>
            <label for="subj_gender"><?php __("Gender") ?>:</label>
            <select name="subj_gender">
               <option value="m" <?php if($subj_gender == "m") { ?> selected="selected" <?php } ?> ><?php __("male") ?></option>
               <option value="f" <?php if($subj_gender == "f") { ?> selected="selected" <?php } ?> ><?php __("female") ?></option>
            </select>
            <label for="subj_status"><?php __("Status") ?>:</label>
            <select name="subj_status">
               <option value="p" <?php if($subj_status == "p") { ?> selected="selected" <?php } ?> ><?php __("pending") ?></option>
               <option value="a" <?php if($subj_status == "a") { ?> selected="selected" <?php } ?> ><?php __("active") ?></option>
            </select>


            <label for="subj_email"><?php __("Email") ?>:</label>
            <input class="required" name="subj_email" type="text" value="<?php echo $subj_email ?>" />
         </fieldset>
      </div>
      
      <div class="en">
         <fieldset>
            <label for="lists"><?php __("Subject belongs to the following lists") ?>:</label>
   
            <?php
               $rel_lists = get_rel_list_for_subj($subj_id);
               $all_lists = get_all_lists();
           
               while ($row = mysql_fetch_array($all_lists)) {
                  $list_id = $row["list_id"];
                  $list_name = decode($row["name"], $lang);
               ?>
   
               <input type="checkbox" <?php if (in_array($list_id, $rel_lists)) {echo "checked=\"checked\"" ; } ?> name="lists[]" value="<?php echo $list_id ?> " /> <?php echo $list_name ?><br />
            <?php 
            }
            ?>
         </fieldset>
      </div>

      <div class="clear">
         <input name="submit" type="submit" value="<?php __("Save") ?>  &raquo;" class="buton"/>
      </div>
   </form>


<?php
} else {
?>

   <h1 class="subjects">Add subject</h1>
   
   <form id="edit_list" action="process_subject.php" method="POST">
      <input type="hidden" name="action" value="add"/>

      <div class="ro">
         <fieldset>
            <label for="subj_first_name"><?php __("First Name") ?>:</label>
            <input class="required" name="subj_first_name" type="text" value="" />
            <label for="subj_last_name"><?php __("Last Name") ?>:</label>
            <input class="required" name="subj_last_name" type="text" value="" />
         </fieldset>
         <fieldset>
            <label for="subj_gender"><?php __("Gender") ?>:</label>
            <select name="subj_gender">
               <option value="m"><?php __("male") ?></option>
               <option value="f"><?php __("female") ?></option>
            </select>
            <label for="subj_email"><?php __("Email") ?>:</label>
            <input class="required" name="subj_email" type="text" value="" />
         </fieldset>
      </div>

      <div class="en">
         <fieldset>
            <label for="lists"><?php __("Subject belongs to the following lists") ?>:</label>
            <?php
               $lists = get_all_lists();
               while ($row = mysql_fetch_array($lists)) {
                  $list_id = $row["list_id"];
                  $list_name = decode($row["name"], $lang);
               ?>
               <input type="checkbox" name="lists[]" value="<?php echo $list_id ?> " /> <?php echo $list_name?><br />
               <?php 
               }
            ?>
         </fieldset>
      </div>

      <div class="clear">
         <input name="submit" type="submit" value="<?php __("Send") ?>  &raquo;" class="buton"/>
      </div>
   </form>

<?php
}
?>

<?php require_once("../includes/footer.php") ?>
