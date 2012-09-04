<?php require_once("../includes/header.php") ?>
<?php $_utils = new Utils() ?>

   <h1 class="studies"><?php __("Study Management") ?></h1>
   
   <div id="list_details">
   <?php output_message() ?>
         <ul>
               <li class="head">
                  <span class="name"><?php __("Study name") ?></span>
                  <span class="description"><?php __("Description") ?></span>
               </li>
         <?php          
            $result = get_all_studies ();

            while ($row = mysql_fetch_array($result)) {
               $study_id = $row["study_id"];
               $study_name_ro = decode($row["name"], "ro");
               $study_name_en = decode($row["name"], "en");
               $study_desc_ro = decode($row["desc"], "ro");
               $study_desc_en = decode($row["desc"], "en");
               $study_name = decode($row["name"], $lang);
               $study_desc = decode($row["desc"], $lang);
            ?>
               <li>
                  <span class="name"><?php echo $study_name ?></span>
                  <span class="description"><?php echo $study_desc ?></span>
                  <span class="view"><a href="view_study.php?study_id=<?php echo $study_id ?>"><?php __("View") ?></a></span>
                  <span class="edit"><a href="edit_study.php?study_id=<?php echo $study_id ?>"><?php __("Edit") ?></a></span>
               </li>
            <?php 
            }
         ?>
         </ul>
         <p class="clear"><a href="edit_study.php"><?php __("Add study") ?></a></p>
   </div>
<?php require_once("../includes/footer.php") ?>
