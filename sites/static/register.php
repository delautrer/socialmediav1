<style>
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
.redAlert {
  background-color: #FF4747 ;
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
  $errorMessage = "";
  $error = false;
  $erstellt = false;
  if(isset($_POST['Email'])){
      $bname = $_POST['BName'];
      $email = $_POST['Email'];
      $passwort = $_POST['Passwort'];

      $hash = '$2a$07$41ihiodaw8dt21398fgv2398io7u$';
      $passwort = crypt($passwort, $hash);


      $sql = "SELECT * FROM `user` WHERE BName='".$bname."'";
      $abfrage = mysqli_query($verbindung, $sql);
      if(mysqli_num_rows($abfrage) > 0){
        while($hahaha = mysqli_fetch_assoc($abfrage)){
          $error = true;
          $errorMessage = "Dieser Benutzername wird bereits verwendet!";
        }
      }
      $sql = "SELECT * FROM `user` WHERE Email='".$email."'";
      $abfrage = mysqli_query($verbindung, $sql);
      if(mysqli_num_rows($abfrage) > 0){
        while($hahaha = mysqli_fetch_assoc($abfrage)){
          $error = true;
          $errorMessage = "Diese E-Mail wird bereits verwendet!";
        }
      }
      if($error == false){
        $avcode = crypt($bname, '$2a$07$41oIduwaMdhaih8io7u$');
        $sql = "INSERT INTO `user` (BName, Passwort, Email, Follower, Follows, Beschreibung, ProBild, AktivierungsCode) VALUES
                  ('{$bname}','{$passwort}','{$email}', 0, 0, 'Hallo ProjektA!! Ich bin nun auch da!', 'profile/unknown.jpg' , '{$avcode}')";
        $abfrage = mysqli_query($verbindung, $sql);
        $erstellt = true;
        $ac_link = "http://projekta.bloxeon.net/?p=activate&v=" . $avcode . "&m=" . $bname . "";
        echo '<h4 class="redAlert"> Aufgrund der Probleme mit unserem E-Mail-Service, <a href="'.$ac_link.'">kannst du deinen Account bestätigen, indem du hier klickst!</a></h4>';
        $to = $email;
        $headers  = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
        $headers  .= "From: Bloxeon<noreply@bloxeon.net>" . "\r\n";
        $subject = "Accountbestätigen";
        $message = "<html>
                      <body>
                          <h4>Hey {$bname}</h4>
                          <p>Vielen Dank für deine Registierung auf Bloxeon.net!
                            <a href='{$ac_link}'>Klicke hier um deinen Account zubestätigen</a>
                          </p>
                          <h5>
                          Dein<br>
                          Bloxeon-Team <3
                          </h5>
                      </body>
                  </html>";
        mail( $to, $subject, $message, $headers );
      }
  }

 ?>


<h1>Registieren</h1>
<?php
  if($erstellt == false){
    echo("".$errorMessage)
?>
<form method="POST" action="?p=register">
  <br>
  <table>
    <tr><td>Benutzername: </td><td><input required name="BName" <?php if(isset($_POST['BName'])){ echo("value=" . $_POST['BName']);} ?> ><br></td></tr>
    <tr><td>E-Mail: </td><td><input required name="Email" <?php if(isset($_POST['Email'])){ echo("value=" . $_POST['Email']);} ?> type=email ><br></td></tr>
    <tr><td>Passwort: </td><td><input required name="Passwort" type=password><br></td></tr>
    <input type="hidden" value="register" name="old" />
  </table>
  <br>
  <input type=submit name=submit value="Registieren">
  <br>
  <a href="?p=profile">Bereits Mitglied? Dann melde dich an!</a>
</form>
<?php
  } else {
    echo "<br><br><br><h5>Dir wurde ein Bestätigungslink an deine E-Mail gesendet.</h5>";
  }
?>
