<?php require_once("../includes/header.php") ?>

<?php
if(isset($_GET["quest_id"]) && isset($_GET["subj_id"]) && isset($_GET["study_id"]))
{
  $quest_id = $_GET["quest_id"];
  $subject_id = $_GET["subj_id"];
  $subject_name = get_subj_name($subject_id);
  $quest_name = get_questionnaire_name($quest_id, $lang);
  $study_id = $_GET["study_id"];
  $study_name = get_study_name($study_id, $lang);
?>   
  <h1 class="quest"><?php __("Scoring")?> - <?php echo $quest_name ?></h1>
  <p><strong><?php __("Subject name") ?></strong>: <?php echo $subject_name; ?></p>  

  <div id="list_details">
    <ul>
<?
    
  $query = "SELECT * FROM results WHERE results.subj_id = ".$subject_id." AND results.study_id = ".$study_id.' AND questionnaire_id='.$quest_id;
  $result = mysql_query($query, $dbconnect);
  $quest = array();
  while($row = mysql_fetch_assoc($result))
  {
    $quest[] = $row;
  }
  //urat dar repede
  if ($quest_id == 4 || $quest_id == 7)// E-RIBS & M-RIBS
  {
    $max = 5;
    $map = array(
      "Acord puternic" => 1,
      "Intrucatva de acord" => 2,
      "Dezacord partial" => "3",
      "Dezacord puternic" => 4
    );
    $subscale = array(
      "(I) Irrational Beliefs Performance" => array(1,3,4,5,9),
      "(II) Rational Beliefs Performance" => array(2,6,7,8,10),
      "(III) Irrational Beliefs Control" => array(11,14,19,13,15),
      "(IV)Rational Beliefs Control" => array(12,16,17,18,20),
      "(V) Irrational Beliefs Emotional Comfort" => array(21,24,29,23,25),
      "(VI) Rational Beliefs Emotional Comfort" => array(22,26,27,28,30),
      "Rational Beliefs Score" => array(2,6,7,8,10,12,16,17,18,20,22,26,27,28,30),
      "Irrational Beliefs Score" => array(1,3,4,5,9,11,14,19,13,15,21,24,29,23,25),
      "Total Irrational Beliefs Score" => array(1,3,4,5,9,11,14,19,13,15,21,24,29,23,25,-2,-6,-7,-8,-10,-12,-16,-17,-18,-20,-22,-26,-27,-28,-30),
    );
    foreach ($subscale as $nume => $valori)
    {
?>
      <li>
        <ul class="grid">
          <li class="title">
            <?php echo $nume ?>:
          </li>
          <li class="title">
<?php
      $valoare = 0;
      foreach ($valori as $ind)
      {
        if ($ind > 0)
          $valoare += $map[$quest[$ind - 1]['data']];
        else
        {
          $ind *= -1;
          $valoare += 5 - $map[$quest[$ind - 1]['data']];
        }
      }
      echo $valoare;
?>  
          </li>
        </ul>
      </li>
<?php      
    }
  }
} else 
{
   redirect("manage_subjects.php");
}
?>
      </ul>
   </div><!-- list details -->
<?php require_once("../includes/footer.php") ?>