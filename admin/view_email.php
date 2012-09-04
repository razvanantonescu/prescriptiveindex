<?php require_once("../includes/header.php") ?>
<?php $_utils = new Utils() ?>

<?php
if(isset($_GET["email_id"])){
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
   <h1 class="emails"><?php echo $email_name ?></h1>
   
   <div id="list_details">
   <?php echo output_message() ?>
      <p><strong><?php __("Template Name") ?>:</strong> <?php echo $email_name ?></p>
      <p><strong><?php __("Body") ?>:</strong> <?php echo $email_body ?></p>
      
      <p><?php __("Studies related to this template") ?>:</p>
      <ul>
      <?php
         $rel_studies = get_studies_for_email($email_id);
         while ($row = mysql_fetch_array($rel_studies)) {
            $study_id = $row["study_id"];
            $study_nume = decode($row["name"], $lang);
      ?>
         <li><a href="view_study.php?study_id=<?php echo $study_id ?>"><?php echo $study_nume ?></a></li>
      <?php
         }
      ?>
      </ul>
      <p><a href="edit_email.php?email_id=<?php echo $email_id ?>"><?php __("Edit template") ?></a></p>
   </div>

<?php
} else {
   $_utils->_redirect("manage_emails.php");
}
?>

<?php require_once("../includes/footer.php") ?>
