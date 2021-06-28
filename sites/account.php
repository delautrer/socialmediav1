<?php if(isset($_SESSION['UID'])) {
  $uid = $_SESSION['UID'];
  if(isset($_POST['beschreibung'])){
    $beschreibung = $_POST['beschreibung'];
    $sql = "UPDATE `user` SET `Beschreibung` = '{$beschreibung}' WHERE `user`.`UID`='{$uid}' LIMIT 1";
    $abfrage = mysqli_query($verbindung, $sql);
    header("Location: ?p=profile");
  }
  if(isset($_POST['pbchange'])){
    if($_FILES['image']['name'] != null){

      $image = $_FILES['image']['name'];
      $image_name = basename($image);
      $target = "profile/".$image_name;

      $sql = "UPDATE `user` SET `ProBild` = '{$target}' WHERE `user`.`UID`='{$uid}' LIMIT 1";
      $abfrage = mysqli_query($verbindung, $sql);
      $uid = $_SESSION['UID'];
      $target = "upload/".$target;
      if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
        header("Location: ?p=profile");
      }else{
      }
    }
  }
  if(isset($_POST['kpchange'])){
    if(isset($_POST['privat'])){
      $sql = "UPDATE `user` SET `Private` = TRUE WHERE `user`.`UID`='{$uid}' LIMIT 1";
      echo "Privat: ja";
      $abfrage = mysqli_query($verbindung, $sql);
    }else{
      $sql = "UPDATE `user` SET `Private` = FALSE WHERE `user`.`UID`='{$uid}' LIMIT 1";
      echo "Privat: nein";
      $abfrage = mysqli_query($verbindung, $sql);
    }
  }
  $benutzer = "";
  $sql = "SELECT * FROM `user` WHERE UID='{$uid}' LIMIT 1";
  $abfrage = mysqli_query($verbindung, $sql);
  if(mysqli_num_rows($abfrage) > 0){
    while($user = mysqli_fetch_assoc($abfrage)){
      $benutzer = $user;
    }
  }
?>
<style>
  #account input[type="text"]{
    width: 450px;
  }
</style>
<div id="account">

  <h1>Kontoeinstellungen von <?php echo $benutzer['BName']; ?></h1>
  <hr>
  <br>
  <h3>Beschreibung ändern:</h3>
  <form action="?p=account" method="post">
    <input type="submit" name="submit" value="Ändern">
    <input type="text" name="beschreibung" value="<?php echo $benutzer['Beschreibung']; ?>">
  </form>
  <br>
  <h3>Profilbild ändern:</h3>
  <form method="post" action="?p=account" enctype="multipart/form-data">
    <button type="submit" name="upload">Profilbild hochladen</button>
    <input type="hidden" name="size" value="1000000">
    <input type="hidden" name="pbchange" value="1">
    <input type="file" accept=".jpg,.jpeg,.png" name="image">
  </form>
  <br>
  <h3>Kontoprivatsphäre</h3>
  <form action="?p=account" method="post">
    <table style="margin-left: 40px;">
    <br>
      <tr>
        <td><p>Privates Konto</p></td>
        <td><input type="checkbox" name="privat" <?php if($benutzer['Private'] == true) echo "checked" ?>></td>
      </tr>
    </table>
    <br>
    <input type="hidden" name="kpchange" value="1">
    <input type="submit" name="submit" value="Einstellungen übernehmen">
  </form>
  <?php } else {
      echo "Du musst eingeloggt sein, um diesen Bereich zusehen! Bitte logge dich ein!";
      echo "<br><a href='?p=profile'>Anmelden</a>";
  } ?>
</div>
