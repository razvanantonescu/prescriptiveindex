<?php

class Utils {

   function Utils() {
      
   }

   function _confirm_query($result_set) {
      if (!$result_set) {
         die("Database query failed: " . mysql_error());
      }
   }

   function _redirect($target = NULL) {
      if ($target != NULL) {
         header("Location: {$target}");
         exit;
      }
    }


}


?>