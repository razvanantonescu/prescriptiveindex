<?php
  define('MYSQL_USER', 'relu');
  define('MYSQL_PASS', 'r3lu123');
  define('MYSQL_DB', 'uvt');
  define('MYSQL_SERV', 'localhost');

  $dbconnect = mysql_connect(MYSQL_SERV, MYSQL_USER, MYSQL_PASS);
  mysql_select_db(MYSQL_DB, $dbconnect);
?>