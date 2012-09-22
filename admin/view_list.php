<?php require_once("../includes/header.php") ?>
<?php $_utils = new Utils() ?>

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
   <h1 class="lists"><?php echo $list_name ?></h1>
   
   <div id="list_details">
   <?php output_message() ?>

      <p><strong><?php __("List Name") ?>:</strong> <?php echo $list_name ?></p>
      <p><strong><?php __("Description") ?>:</strong> <?php echo $list_desc ?></p>
      <p>
         <strong><?php __("Status") ?>:</strong>
         <?php
            if($list_public == 1) {
               __("public list");
            } else {
               __("private list");
            }
         ?>
      </p>
      <p><strong><?php __("Subjects") ?>:</strong></p>
      <ul>
         <?php
            $subjects = get_subj_for_list($list_id);
            while ($row = mysql_fetch_array($subjects)) {
               $subj_id = $row["subj_id"];
               $subj_first_name = $row["first_name"];
               $subj_last_name = $row["last_name"];
         ?>
         <li><a href="view_subject.php?subj_id=<?php echo $subj_id ?>"><?php echo $subj_first_name . " " . $subj_last_name ?></a></li>
         <?php
            }
         ?>
      </ul>
      <p><a href="edit_list.php?list_id=<?php echo $list_id ?>"><?php __("Edit list") ?></a></p>
      <p><a href="procesare_liste.php?list_id=<?php echo $list_id ?>&action=delete"><?php __("Delete list") ?></a></p>

      <form action="import_subjects.php" method="post" enctype="multipart/form-data">
         <label for="file"><?php __('Import subjects from csv file') ?>*</label>
         <input type="hidden" name="list_id" value="<?php echo $list_id ?>" />
         <input type="file" name="file" id="file" />
         <input type="submit" name="submit" value="<?php __("Import subjects") ?>" onclick="submit_form(this); return false;" />
      </form>
      <p>* <?php __('Subjects will be automatically included in this list') ?></p>

      <script>
         function submit_form(element) {
            var elem = $(element);
            var form = elem.parent('form');
            var fileName = $("#file").val();
            
            if(fileName == '') {
               alert('Nu ati selectat nici un fisier!');
            } else {
               form.submit();
            }
         };
      </script>

   </div>

<?php
} else {
   $_utils->_redirect("manage_lists.php");
}
?>
<?php require_once("../includes/footer.php") ?>