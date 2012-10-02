<?
session_start();

$username = "test";
$password = "test";

if(isset($_GET['logout']))
{
  unset($_SESSION["login"]);
  header('Location: http://www.prescriptiveindex.ro/');
  exit;
}

if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) || !isset($_SESSION["login"]))
{
  header("WWW-Authenticate: Basic realm=\"UVT - Screening Platform\"");
  header("HTTP/1.0 401 Unauthorized");
  $_SESSION["login"] = true;
  echo "You are unauthorized ... ";
  echo "[<a href='" . $_SERVER['PHP_SELF'] . "'>Login</a>]";
  exit;
}
else
{
  if($_SERVER['PHP_AUTH_USER'] == $username && $_SERVER['PHP_AUTH_PW'] == $password)
  {
  }
  else
  {
    unset($_SESSION["login"]);
    header('Location: http://www.prescriptiveindex.ro/');
  }
}

include_once('main.php');

?>