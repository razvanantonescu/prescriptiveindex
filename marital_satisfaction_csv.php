<?
  header('Content-type: text/csv');
  header('Content-disposition: attachment;filename=marital_satisfaction.csv');
  include_once 'mysql_conf.php';

  function outputCSV($data) 
  {
    $outstream = fopen("php://output", 'w');

    function __outputCSV(&$vals, $key, $filehandler) 
    {
      fputcsv($filehandler, $vals, ',', '"');
    }
    array_walk($data, '__outputCSV', $outstream);

    fclose($outstream);
  }


  $query = "select * from marital_satiffaction";
  $result = mysql_query($query);

  $data = array();

  $i = 0;
  while ($row = mysql_fetch_assoc($result))
  {
    if (!$i)
    {
      $i++;
      $data[] = array_keys(json_decode($row['data'], true));
    }
    $data[] = array_values(json_decode($row['data'], true));
  }
  
  outputCSV($data);
  
?>