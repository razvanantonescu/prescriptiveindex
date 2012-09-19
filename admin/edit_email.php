<?php require_once("../includes/header.php") ?>
<?php $_utils = new Utils() ?>

<?php
if(isset($_GET["email_id"])){ /////////////////////////////// EDIT email
   $email_id = $_GET["email_id"];

   $result = get_email($email_id);
   $row = mysql_fetch_array($result);
      $email_id = $row["email_id"];
      $email_name_ro = decode($row["name"], "ro");
      $email_name_en = decode($row["name"], "en");
      $email_body_ro = decode($row["body"], "ro");
      $email_body_en = decode($row["body"], "en");
      $email_name = decode($row["name"], $lang);
      $email_body = decode($row["body"], $lang);
   ?>

   <h1 class="emails"><?php __("Edit email template") ?></h1>
   
   <form id="edit_email" action="process_emails.php" method="POST">
      <input type="hidden" name="email_id" value="<?php echo $email_id ?>"/>
      <input type="hidden" name="action" value="edit"/>

      <fieldset>
         <div class="ro">
            <label for="email_name_ro"><?php __("Template Name (ro)") ?></label>
            <input class="required" name="email_name_ro" type="text" value="<?php echo $email_name_ro ?>" />
         </div>
         <div class="en">
            <label for="email_name_en"><?php __("Template Name (en)") ?></label>
            <input class="required" name="email_name_en" type="text" value="<?php echo $email_name_en ?>" />
         </div>
      </fieldset>

      <fieldset>
         <div class="ro">
            <label for="email_body"><?php __("Body (ro)") ?></label>
            <textarea class="required" name="email_body_ro"><?php echo $email_body_ro ?></textarea>
         </div>
         <div class="en">
            <label for="email_body"><?php __("Body (en)") ?></label>
            <textarea class="required" name="email_body_en"><?php echo $email_body_en ?></textarea>
         </div>
      </fieldset>

      <div class="clear">
         <input name="submit" type="submit" value="<?php __("Save") ?>  &raquo;" class="buton"/>
      </div>
   </form>

<?php
} else { ///////////////////////////////////////////////// ADD email
?>

   <h1 class="emails"><?php __("Add email template") ?></h1>
   
   <form id="add_email" action="process_emails.php" method="POST">
      <input type="hidden" name="action" value="add"/>

      <fieldset>
         <div class="ro">
            <label for="email_name_ro"><?php __("Template Name (ro)") ?></label>
            <input class="required" name="email_name_ro" type="text" value="" />
         </div>
         <div class="en">
            <label for="email_name_en"><?php __("Template Name (en)") ?></label>
            <input class="required" name="email_name_en" type="text" value="" />
         </div>
      </fieldset>

      <fieldset>
         <div class="ro">
            <label for="email_body"><?php __("Body (ro)") ?></label>
            <textarea class="required" name="email_body_ro"></textarea>
         </div>
         <div class="en">
            <label for="email_body"><?php __("Body (en)") ?></label>
            <textarea class="required" name="email_body_en"></textarea>
         </div>
      </fieldset>

      <div class="clear">
         <input name="submit" type="submit" value="<?php __("Send") ?>  &raquo;" class="buton"/>
      </div>
   </form>

<?php
}
?>
   
<?php require_once("../includes/footer.php") ?>