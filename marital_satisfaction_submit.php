<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <title>Satisfactie Maritala</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="css/reset.css" rel="stylesheet" type="text/css" />
        <link href="css/uvt.css" rel="stylesheet" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="js/script.js"></script>

</head>
<body style='padding:20px'>
<div id="wrapper">
  <div id='main_content'>
    <p class="title">Prescriptive Index</p>
    <div id="list_details" style="margin-top:30px;">
      <h2><strong>Chestionar - Satisfactie Maritala</strong></h2>
<?
  include_once 'mysql_conf.php';

  $checkip = 1;
  
  
  $completat = 0;
  
  if ($checkip)
  {
    $query = "select * from marital_satiffaction where ip = '".$_SERVER['REMOTE_ADDR']."' and email = '".mysql_escape_string($_POST['email'])."'";
    $result = mysql_query($query);
    if (mysql_num_rows($result))
    {
      echo "<em>Chestionar deja completat!</em><br>";
      echo "Cineva cu acceasi adresa de email(".$_POST['email'].") si de pe acelasi IP(".$_SERVER['REMOTE_ADDR'].") a completat deja acest chestionar.<br>";
      $completat = 1;
    }
  }

  if (!$completat)
  {
    $query = "insert into marital_satiffaction values (NULL, '".mysql_escape_string($_POST['email'])."', '".$_SERVER['REMOTE_ADDR']."', '".json_encode($_POST)."')";
    mysql_query($query);
    echo mysql_error();
    
    echo "<em>Raspunsurile au fost salvate!</em><br>";
  }

  echo "<br><br><em>Multumim pentru participare.</em><br>";
  echo "<br><br>Inapoi la <a href='http://www.prescriptiveindex.ro/marital_satiffaction.php'>chestionar</a> sau la <a href='http://www.prescriptiveindex.ro'>prescriptiveindex.ro</a>.";
  
?>