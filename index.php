<!DOCTYPE html>
<?php
session_start();
if(isset($_GET['p'])){
  $p = $_GET['p'];
  if($p == "register"){
    $p = "static/" . $p;
  }
  if($p == "activate"){
    $p = "static/" . $p;
  }
  if($p == "logout"){
    $p = "static/" . $p;
  }
  if($p == "upload"){
    $p = "static/" . $p;
  }
} else {
  $p = "index";
}

  $server = 'localhost';
  $benutzer = 'root';
  $passwort = 'dbpasswort(root)';
  $datenbank = 'dbname';

  $verbindung = @mysqli_connect($server, $benutzer, $passwort);

  if($verbindung) {
    mysqli_select_db($verbindung, $datenbank);
    if(mysqli_error($verbindung)){
      echo "Fehler: " . mysqli_error($verbindung);
    } else {}
  }else{
    echo "Verbindungsfehler: " . mysqli_connect_error($verbindung);
  }

 ?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProjektA</title>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <script src="https://use.fontawesome.com/2920c81cef.js"></script>
    <style>
      * {
        padding: 0;
        margin: 0;
        font-family: sans-serif;
      }
      body {
        background-color: #F5EEEE;
      }
    </style>
  </head>
  <body>
    <?php include("sites/static/header.php") ?>
    <div id="content">
      <?php include("sites/" . $p . ".php") ?>
    </div>
    <?php include("sites/static/footer.php") ?>
  </body>
</html>
