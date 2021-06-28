<?php
  $benutzer = "";
  $error = false;
  $uid = "";
  $private = false;
  $follows = false;
  if(isset($_GET['suid'])){
    $sql = 'SELECT * FROM `user` WHERE `UID` ="'.$_GET['suid'].'" LIMIT 1';
    $abfrage = mysqli_query($verbindung, $sql);
    if(mysqli_num_rows($abfrage) > 0){
      $benutzer = mysqli_fetch_assoc($abfrage);
      $uid = $_GET['suid'];
      if($benutzer['Private'] == true){
        $private = true;
      }
      if(isset($_POST['follow'])){
        if(isset($_SESSION['UID'])){
          $follower = $_SESSION['UID'];
          // if($_follower != $uid){
            $sql = "SELECT UID FROM userfollow WHERE FollowUID='{$uid}' AND UID='{$follower}'";
            $abfrage = mysqli_query($verbindung, $sql);
            if(mysqli_num_rows($abfrage) > 0){
              //FOLGT
              $followuid = mysqli_fetch_assoc($abfrage);
              $sql = "DELETE FROM userfollow WHERE UID='{$follower}' AND FollowUID='{$uid}'";
              $abfrage = mysqli_query($verbindung, $sql);
              // header("Location: ?p=profile&suid=".$uid);
            }else{
              //FOLGT NIGHT
              $sql = "INSERT INTO userfollow (UID, FollowUID) VALUES ('{$follower}','{$uid}')";
              $abfrage = mysqli_query($verbindung, $sql);
              // header("Location: ?p=profile&suid=".$uid);
            }
          // }
        }
      }
    }
  }else
  if(!isset($_SESSION['UID'])) {
    if(isset($_POST['BName'])){
      $bname = $_POST['BName'];
      $passwort = $_POST['Passwort'];
      $sql = 'SELECT * FROM `user` WHERE `BName` ="'.$bname.'"';
      $abfrage = mysqli_query($verbindung, $sql);
      if(mysqli_num_rows($abfrage) == 0){
        $errorMessage = "Benutzername oder Passwort ist ungültig";
        include("sites/static/login.php");
        $error = true;
      }else{
        while($user = mysqli_fetch_assoc($abfrage)){
          if (crypt($passwort, $user['Passwort']) == $user['Passwort']) {
            if($user['Aktiviert'] == 1) {
              $_SESSION['UID'] = $user['UID'];
              $benutzer = $user;
              header("Location: ?p=profile&suid=".$user['UID']);
            } else {
              $errorMessage = "Dieser Account ist noch nicht aktiviert. Aktiviere ihn, indem du die E-Mail bestätigst.";
              include("sites/static/login.php");
              $error = true;
            }
          } else {
            $errorMessage = "Benutzername oder Passwort ist ungültig";
            include("sites/static/login.php");
            $error = true;
          }
        }
      }
    } else {
      $errorMessage = "";
      include("sites/static/login.php");
      $error = true;
    }
  } else {
    $uid = $_SESSION['UID'];
    if(isset($_POST['upload'])){
      if($_FILES['image']['name'] != null){

        $image = $_FILES['image']['name'];
        $image_name = basename($image);
        $image_beschreibung = mysqli_real_escape_string($verbindung, $_POST['image_beschreibung']);
        $target = "upload/posts/".$image_name;

        $sql = "INSERT INTO `bilder` (Likes, Beschreibung, Source) VALUES (0, '{$image_beschreibung}','{$target}')";
        $abfrage = mysqli_query($verbindung, $sql);
        $uid = $_SESSION['UID'];

        $sql = "SELECT * FROM `bilder` WHERE Source='{$target}' AND Beschreibung='{$image_beschreibung}'";
        $abfrage = mysqli_query($verbindung, $sql);
        $bid = "";
        if(mysqli_num_rows($abfrage) > 0){
          while($bild = mysqli_fetch_assoc($abfrage)){
            $bid = $bild['BID'];
          }
        }
        $_FILES['image']['name'] = null;
        $sql = "INSERT INTO `userbild`(UID, BID) VALUES ('{$uid}','{$bid}')";
        $abfrage = mysqli_query($verbindung, $sql);

        if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
          header("Location: ?p=profile&suid=".$uid);
        }else{
        }
      }
    }
  }
?>

<style>
  #profile-head {
    height: 150px;
    padding: 20px 40px;
    border-bottom: 2px solid gray;
    border-right: 1px solid lightgray;
    border-left: 2px solid gray;
    border-top: 1px solid lightgray;
    display: flex;
    align-items: center;
  }
  #profile-head #profilepicture img {
      width: 150px;
      height: 150px;
      border-radius: 100%;
      object-fit: cover;
      object-position: 50%;
      background-color: gray;
      border: 2px solid lightgray;
  }
  #profile-head #profile-info {
    background-color: lightgray;
    width: 100%;
    max-width: 100%;
    margin: 0px 15px;
    padding: 15px 0;
    position: relative;
  }
  #profile-head #profile-info h1 {
    /* text-decoration: underline; */
    margin: 0 0 10px 35px;
  }
  #profile-head #profile-info p {
    margin: 15px 0 15px 50px;
  }
  #profile-info #profile-follow {
    position: absolute;
    right: 2vh;
    top: 2.2vh;
  }
  #profile-info #profile-follow .count {
    display: inline;
    text-transform: uppercase;
    text-align: center;
  }
  #profile-info #profile-follow #follow-btn {
    display: inline;
    padding: 5px 25px;
    border: 1px solid #5284FF;
    border-radius: 15px;
    border-bottom-color: blue;
    border-right-color: blue;
    background-color: #5284FF;
    text-transform: uppercase;
    font-size: 1.1em;
    color: white;
    margin: 0 5px 0 15px;
  }
  #profile-info #profile-follow #follow-btn:hover {
    display: inline;
    border: 1px solid blue;
    background-color: white;
    text-transform: uppercase;
    color: #5284FF;
  }
  #posts {
    display: table;
    width: 70%;
    min-height: 500px;
    height: auto;
    margin: 40px auto 50px auto;
  }
  h4 {
    margin: 40px;
    text-align: center;
    padding: 15px;
    border-bottom: 2px solid gray;
    border-right: 1px solid lightgray;
    border-left: 2px solid gray;
    border-top: 1px solid lightgray;
  }
  #posts .post {
    display: inline-table;
    margin-left: 5px;
  }
  #posts .post input[type="image"]:hover {
    border-color: gray;
  }
  #posts .post input[type="image"] {
    width: 23vh;
    height: 23vh;
    object-fit: cover;
    object-position: 50%;
    border: 5px solid lightgray;
  }
</style>

<?php
  //Abfrage der Nutzer ID vom Login
  if($error == false) {
    $sql = 'SELECT * FROM `user` WHERE `UID` ="'.$uid.'" LIMIT 1';
    $abfrage = mysqli_query($verbindung, $sql);
    if(mysqli_num_rows($abfrage) > 0){
      $benutzer = mysqli_fetch_assoc($abfrage);
    }
    echo "<div id='profile-head'>";
      echo "<div id='profilepicture'><img src='upload/".$benutzer['ProBild']."'></div>";
      echo "<div id='profile-info'>";
        if($benutzer['Rang'] == "admin"){
          echo "<h1 style='color:red;'>".$benutzer['BName']."</h1>";
        }else{
          echo "<h1>".$benutzer['BName']."</h1>";
        }
        $sql = "SELECT COUNT(`FollowUID`) AS `Follower` FROM `userfollow` WHERE `FollowUID`='{$uid}'";
        $abfrage = mysqli_query($verbindung, $sql);
        $a_fol=0;
        if(mysqli_num_rows($abfrage) > 0){
          while($follower =mysqli_fetch_assoc($abfrage)){
            $a_fol= $follower['Follower'];
          }
        }
        $sql = "SELECT COUNT(`UID`) AS `Follows` FROM `userfollow` WHERE `UID`='{$uid}'";
        $abfrage = mysqli_query($verbindung, $sql);
        $a_folws=0;
        if(mysqli_num_rows($abfrage) > 0){
          while($follows =mysqli_fetch_assoc($abfrage)){
            $a_folws= $follows['Follows'];
          }
        }
        echo "<p class='count'>Follower: ".$a_fol." | Follows: ".$a_folws."</p>";
        echo "<hr>";
        echo "<p>".$benutzer['Beschreibung']."</p>";
        echo "<div id='profile-follow'>";
        if ($_SESSION['UID'] != $uid) {
          $ssuid = $_SESSION['UID'];
          $sql = "SELECT UID FROM userfollow WHERE FollowUID='{$uid}' AND UID='{$ssuid}'";
          $abfrage = mysqli_query($verbindung, $sql);
          if(mysqli_num_rows($abfrage) > 0){
            if(mysqli_fetch_assoc($abfrage) == $_SESSION['UID']);
            //folgt
            echo '<form action="?p=profile&suid='.$uid.'" method="post">';
              echo '<input id="follow-btn" type="submit" name="follow" value="Entfolgen">';
            echo '</form>';
          }else{
              //folgt nicht
            echo '<form action="?p=profile&suid='.$uid.'" method="post">';
              echo '<input id="follow-btn" type="submit" name="follow" value="Folgen">';
            echo '</form>';
          }
        }
        echo "</div>";
      echo "</div>";
    echo "</div>";
    if($_SESSION['UID'] == $uid){
      echo "<a href='?p=upload'>Ein Bild Hochladen</a>";
    }
    if($private == false) {
   ?>
    <div id="posts">
      <?php
        $sql1 = "SELECT * FROM `userbild` WHERE UID='{$uid}' ORDER BY ErsDat DESC";
        $userbild = mysqli_query($verbindung, $sql1);
        if(mysqli_num_rows($userbild) > 0){
          while($ubild = mysqli_fetch_assoc($userbild)) {
            $sql2 = "SELECT * FROM `bilder` WHERE BID='{$ubild['BID']}'";
            $bilderabfrage = mysqli_query($verbindung, $sql2);
            if(mysqli_num_rows($bilderabfrage) > 0){
              while($bild = mysqli_fetch_assoc($bilderabfrage)){
                $bild_source = $bild['Source'];
                echo("<div class='post'>");
                  echo ("<form action='?p=post&bid=".$bild['BID']."' method='post'>");
                    echo("<input type='image' src='{$bild_source}' alt=':/'>");
                  echo ("</form>");
                echo("</div>");
              }
            }
          }
        } else {
          echo "<h4>Es sind noch keine Beiträge verfügbar :/</h4>";
        }
      }else{
        echo "<h4>Das Profil von ".$benutzer['BName']." ist auf Privat gestellt!</h4>";
      }
      echo "</div>";
     }?>
