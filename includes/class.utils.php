<?php
  //define('MYSQL_USER', 'root');
  //define('MYSQL_PASS', '');
  //define('MYSQL_DB', 'uvt');
  //define('MYSQL_SERV', 'localhost');

//  $dbconnect = mysql_connect(MYSQL_SERV, MYSQL_USER, MYSQL_PASS);
//  mysql_select_db(MYSQL_DB, $dbconnect);
//
//
//class MySql {
//	var $idlink;
//	var $result;
//	var $resid;
//	var $queryString;
//
//	function __construct()
//	{
//			$this->Connect(MYSQL_SERV,MYSQL_USER,MYSQL_PASS);
//			$this->idlink = $this->resid;
//	}
//}


/*
 * Utils Class
 * redirect
 * confirm query
 */

class Utils {
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
   
   function __($txt) {
      global $dbconnect;
      global $lang;
      $result = mysql_query("select * from texts where `mydata` ='".mysql_real_escape_string(htmlspecialchars($txt))."' ");
      if (!mysql_num_rows($result)) {
         mysql_query("insert into texts (`mydata`) values ('".mysql_real_escape_string(htmlspecialchars($txt))."') ");
      } else {
         if ($lang == 'ro') {
            $row = mysql_fetch_array($result);
            $txt_ro = $row['ro'];
            if($txt_ro != NULL) {
               $txt = $txt_ro;
            }
         }
      }
      echo $txt;
   }
}


?>