<style media="screen">
.greenAlert {
  background-color: lightgreen;
  margin: 20px;
  text-align: center;
  padding: 15px;
  border-bottom: 2px solid gray;
  border-right: 1px solid lightgray;
  border-left: 2px solid gray;
  border-top: 1px solid lightgray;
}
</style>
<?php
  $error = false;
  if(isset($_GET['v'])) {
    $hashA = $_GET['v'];
    if(isset($_GET['m'])) {
      $bname = $_GET['m'];
      if (crypt($bname, $hashA) == $hashA) {
        $sql = "UPDATE user SET Aktiviert =1 WHERE user.BName='{$bname}' AND user.AktivierungsCode='{$hashA}' LIMIT 1";
        $abfrage = mysqli_query($verbindung, $sql);
        echo '<h4 class="greenAlert"> Dein Account wurde bestätigt! Du kannst dich nun einloggen!! </h4>';
        $errorMessage = "";
        include("login.php");
      }else{
        echo("no");
      }
    }
  }
 ?>

 <?php if($error == false){ ?>
 <?php } ?>
