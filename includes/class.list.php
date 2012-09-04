<?php

class Lists {


   function Lists() {
   }


   function _return_list() {
      $return = array();
      $query = "SELECT * FROM liste ORDER BY list_id ASC;"
      //$this->db->Query($sel) or trigger_error($this->db->Error());
      //while($row = $this->db->getRow())
      //{
      //   $ret[] = $row;
      //}
      //return($ret);
   }
 
}


   $query = "SELECT * FROM liste ORDER BY list_id ASC;";
   $result = mysql_query($query, $dbconnect);
   $_utils->_confirm_query($result);

?>