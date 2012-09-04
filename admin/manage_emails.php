<?php require_once("../includes/header.php") ?>
<?php $_utils = new Utils() ?>

   <h1 class="emails"><?php __("Email Management") ?></h1>
   
   <div id="list_details">
   <?php output_message() ?>
         <ul>
               <li class="head">
                  <span class="name"><?php __("Template name") ?></span>
                  <span class="body"><?php __("Body") ?></span>
               </li>
         <?php          
            $result = get_all_emails ();

            while ($row = mysql_fetch_array($result)) {
               $email_id = $row["email_id"];
               $email_name_ro = stripslashes(decode($row["name"], "ro"));
               $email_name_en = stripslashes(decode($row["name"], "en"));
               $email_body_ro = stripslashes(decode($row["body"], "ro"));
               $email_body_en = stripslashes(decode($row["body"], "en"));
               $email_name = stripslashes(decode($row["name"], $lang));
               $email_body = stripslashes(decode($row["body"], $lang));
            ?>
               <li>
                  <span class="name"><?php echo $email_name ?></span>
                  <span class="description"><?php echo $email_body ?></span>
                  <span class="view"><a href="view_email.php?email_id=<?php echo $email_id ?>"><?php __("View") ?></a></span>
                  <span class="edit"><a href="edit_email.php?email_id=<?php echo $email_id ?>"><?php __("Edit") ?></a></span>
               </li>
            <?php 
            }
         ?>
         </ul>
         <p class="clear"><a href="edit_email.php"><?php __("Add email") ?></a></p>
   </div>
<?php require_once("../includes/footer.php") ?>
