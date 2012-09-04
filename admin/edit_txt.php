<?php require_once("../includes/header.php") ?>

<?php

foreach($_POST as $key=>$value) {

   $result = mysql_query("SELECT * FROM texts WHERE id='".$key."' ");
   $row = mysql_fetch_array($result);
   if (!empty($row["ro"]) && $row["ro"] != $value) {
      $result = mysql_query("UPDATE texts SET `ro` = '".mysql_real_escape_string(htmlspecialchars($value))."' WHERE `id` = '".$key."' ");
   }
   if (empty($row["ro"])) {
      if(!empty($value)) {
         $result = mysql_query("INSERT INTO texts SET `ro` = '".mysql_real_escape_string(htmlspecialchars($value))."' WHERE `id` = '".$key."' ");
      }
   }
}
?>



<form id="translate" method="post" action="edit_txt.php">

<?php
   $query = "SELECT * FROM texts ORDER BY id ASC";
   $result = mysql_query($query, $dbconnect);
   confirm_query($result);
   while ($row = mysql_fetch_array($result)) {
      $index = $row["id"];
      $en = $row["mydata"];
      $ro = $row["ro"];
?>

   <p>
      <label for="<?php echo $index; ?>"><?php echo $en ?></label>
      <input type="text" name="<?php echo $index; ?>" value="<?php echo $ro ?>" />
   </p>
<?php
   }
?>

</form>

<a id="submit_button" href="submit">Submit</a>


<script>
$(document).ready(function(){

   $('#submit_button').click(function() {
     $('#translate').submit();
     return false;
   });

});
</script>
   
<?php require_once("../includes/footer.php") ?>
