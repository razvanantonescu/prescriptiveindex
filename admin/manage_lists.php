<?php require_once("../includes/header.php") ?>

   <h1 class="lists"><?php __("List Management") ?></h1>
   
   <div id="list_details">
   <?php output_message() ?>
         <ul>
            <li class="head">
               <span class="name"><?php __("List name") ?></span>
               <span class="status"><?php __("Status") ?></span>
               <span class="description"><?php __("Description") ?></span>
            </li>

         <?php          
            $all_lists = get_all_lists ();

            while ($row = mysql_fetch_array($all_lists)) {
                  $list_id = $row["list_id"];
                  $list_name_ro = decode($row["name"], "ro");
                  $list_name_en = decode($row["name"], "en");
                  $list_desc_ro = decode($row["desc"], "ro");
                  $list_desc_en = decode($row["desc"], "en");
                  $list_name = decode($row["name"], $lang);
                  $list_desc = decode($row["desc"], $lang);
                  $list_public = $row["public"];
            ?>
            <li>
               <span class="name"><?php echo $list_name ?></span>
               <span class="status"><?php if($list_public==1){echo "public";} else {echo "private";} ?></span>
               <span class="description"><?php echo $list_desc ?></span>
               <span class="view"><a href="view_list.php?list_id=<?php echo $list_id ?>"><?php __("View") ?></a></span>
               <span class="edit"><a href="edit_list.php?list_id=<?php echo $list_id ?>"><?php __("Edit") ?></a></span>
            </li>
            <?php 
            }
         ?>
         </ul>
         <p class="clear"><a href="edit_list.php"><?php __("Add list") ?></a></p>
   </div>
<?php require_once("../includes/footer.php") ?>