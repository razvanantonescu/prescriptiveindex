<?php require_once("../includes/header.php") ?>
<?php $_utils = new Utils() ?>

<?php
if(isset($_GET["study_id"])){
   $study_id = $_GET["study_id"];

   $result = get_study($study_id);
   $row = mysql_fetch_array($result);
      $study_id = $row["study_id"];
      $study_name_ro = decode($row["name"], "ro");
      $study_name_en = decode($row["name"], "en");
      $study_desc_ro = decode($row["desc"], "ro");
      $study_desc_en = decode($row["desc"], "en");
      $study_name = decode($row["name"], $lang);
      $study_desc = decode($row["desc"], $lang);
   ?>
   <h1 class="studies"><?php echo $study_name ?></h1>
   
   <div id="list_details">
   <?php echo output_message() ?>
      <p><strong><?php __("Study Name") ?>:</strong> <?php echo $study_name ?></p>
      <p><strong><?php __("Description") ?>:</strong> <?php echo $study_desc ?></p>
      
      <p><?php __("Questionnaires included in this study") ?>:</p>
      <ul>
      <?php
         $result = get_quest_for_study($study_id);
         while ($row = mysql_fetch_array($result)) {
            $questionnaire_id = $row["questionnaire_id"];
            $questionnaire_nume = decode($row["name"], $lang);
      ?>
         <li><a href="view_quest.php?questionnaire_id=<?php echo $questionnaire_id ?>"><?php echo $questionnaire_nume ?></a></li>
      <?php
         }
      ?>
      </ul>


      <p><?php __("The study applies to the following lists") ?>:</p>
      <ul>
      <?php
         $result = get_list_for_study($study_id);
         while ($row = mysql_fetch_array($result)) {
            $list_id = $row["list_id"];
            $list_name = decode($row["name"], $lang);
      ?>
         <li><a href="view_list.php?list_id=<?php echo $list_id ?>"><?php echo $list_name ?></a></li>
      <?php
         }
      ?>
      </ul>


      <p><?php __("The following subjects are included") ?>:</p>
      <ul>
      <?php
         $result = get_list_for_study($study_id);
         while ($row = mysql_fetch_array($result)) {
            $list_id = $row["list_id"];
            $subjects = get_subj_for_list($list_id);
            while ($subject= mysql_fetch_array($subjects)) {
               $subj_ids[] = $subject["subj_id"];
            }
         }
         if(!empty($subj_ids)) {
            $subj_ids = array_unique($subj_ids);
            foreach($subj_ids as $subj_id) {
      ?>
         <li>
            <a href="view_subject.php?subj_id=<?php echo $subj_id ?>"><?php echo get_subj_name($subj_id) ?></a>

      <?php
               $check = "SELECT * FROM results WHERE study_id = ".$study_id." AND subj_id = ".$subj_id;
               $result = mysql_query($check, $dbconnect);
                  if(mysql_num_rows($result) == 0){
      ?>
                     <a href="../fill.php?subj=<?php echo $subj_id ?>&study=<?php echo $study_id ?>"><?php __("[completeaza]") ?> </a>
      <?php
                  }
      ?>
         </li>
      <?php
            }
         }
      ?>
      </ul>

      <p><a href="edit_study.php?study_id=<?php echo $study_id ?>"><?php __("Edit study") ?></a></p>

      <a class="download csv" href="csv.php?study_id=<?php echo $study_id ?>" title="<?php __('Download in csv format') ?>"><?php __('Download in csv format') ?></a>

   </div>

<?php
} else {
   $_utils->_redirect("manage_studies.php");
}
?>

<?php require_once("../includes/footer.php") ?>
