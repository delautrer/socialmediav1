
    <?php
      $bild = "";
      $benutzer = "";
      $upload_date = "";
      $error = false;
      $a_likes=0;
      if(isset($_GET['p']) == "post"){
        if(isset($_POST['bid'])){
          header("Location: ?p=post&bid=" . $_POST['BID']);
        }else
        if(isset($_GET['bid'])){
          $bid = $_GET['bid'];

          if(isset($_POST['like'])){
            if(isset($_SESSION['UID'])){
              $liker = $_SESSION['UID'];
              $sql = "SELECT `UID` FROM `userlike` WHERE UID='{$liker}' AND BID='{$bid}'";
              $abfrage = mysqli_query($verbindung, $sql);
              if(mysqli_num_rows($abfrage) > 0){
                //LIKEN
                $sql = "DELETE FROM `userlike` WHERE UID='{$liker}' AND BID='{$bid}'";
                $abfrage = mysqli_query($verbindung, $sql);
                header("Location: ?p=post&bid=".$bid);
              }else{
                //LIKEN ENTFERNEN
                $sql = "INSERT INTO `userlike` (UID, BID) VALUES ('{$liker}','{$bid}')";
                $abfrage = mysqli_query($verbindung, $sql);
                header("Location: ?p=post&bid=".$bid);
              }
            }
          }

          $uid = "";
          $sql = "SELECT * FROM userbild WHERE BID='{$bid}' LIMIT 1";
          $abfrage = mysqli_query($verbindung, $sql);
          if(mysqli_num_rows($abfrage) == 1) {
            while($userbild = mysqli_fetch_assoc($abfrage)) {
              $uid = $userbild['UID'];
            }
          }else{
            $error = true;
          }

          $sql = "SELECT * FROM `bilder` WHERE BID='{$bid}' LIMIT 1";
          $abfrage = mysqli_query($verbindung, $sql);
          if(mysqli_num_rows($abfrage) == 1) {
            while($ab_bild = mysqli_fetch_assoc($abfrage)) {
              $bild = $ab_bild;
            }
            $s = strtotime($bild['PostDate']);
            $upload_date = date('d.m.Y', $s);

            $sql = "SELECT COUNT(`UID`) AS `Likes` FROM `userlike` WHERE `BID`='{$bid}'";
            $abfrage = mysqli_query($verbindung, $sql);
            if(mysqli_num_rows($abfrage) > 0){
              while($likes =mysqli_fetch_assoc($abfrage)){
                $a_likes= $likes['Likes'];
              }
            }
          }else{
            $error = true;
          }

          $sql = "SELECT * FROM `user` WHERE UID='{$uid}' LIMIT 1";
          $abfrage = mysqli_query($verbindung, $sql);
          if(mysqli_num_rows($abfrage) == 1) {
            while($ab_user = mysqli_fetch_assoc($abfrage)) {
              $benutzer = $ab_user;
            }
          }else{
            $error = true;
          }
        } else {
          header("Location: ?p=index");
        }
      }
      if($error == false) { ?>
        <div class="post">
        <a href="?p=profile&suid=<?php echo $benutzer['UID']; ?>">
          <img class="profilepicture" src="upload/<?php echo $benutzer['ProBild']; ?>" alt="">
        </a>
        <a href="?p=profile&suid=<?php echo $benutzer['UID']; ?>">
          <h3><?php echo $benutzer['BName']; ?></h3>
        </a>
        <div class="post-options">
          …
          <div class="post-options-content">
            Hier ist noch nichts!
          </div>
        </div>
        <a href="#">
          <img class="post-img" src="<?php echo $bild['Source']; ?>" alt="">
        </a>
        <form action="?p=post&bid=<?php echo $bid; ?>" method="post">
          <?php
          $userid = $_SESSION['UID'];
          $sql = "SELECT * FROM `userlike` WHERE BID='{$bid}' AND UID='{$userid}'";
          $abfrage = mysqli_query($verbindung, $sql);
          if(mysqli_num_rows($abfrage) > 0){
            if(mysqli_fetch_assoc($abfrage) == $_SESSION['UID']);
            //geliked
            if($a_likes > 0){
              echo '<input style="color:red" class="post-likebtn" type="submit" name="like" value="❤">';
            }else{
              echo '<input style="color:red" class="post-likebtn" type="submit" name="like" value="❤">';
            }
          }else{
            //nicht geliked
            if($a_likes > 0){
              echo '<input class="post-likebtn" type="submit" name="like" value="❤">';
            }else{
              echo '<input class="post-likebtn" type="submit" name="like" value="❤">';
            }
          } ?>
          <?php if($a_likes > 0) {?><p class="likes">Gefällt <?php echo $a_likes ?> Mal</p><?php } ?>
        </form>
        <?php if($bild['Beschreibung'] != null || $bild['Beschreibung'] != "") { ?>
          <p class="post-beschreibung"><span><?php echo $benutzer['BName']; ?> </span> <?php echo $bild['Beschreibung']; ?></p>
        <?php } ?>
      </div>
      <?php
    }
   ?>
<style>
 * {
   box-sizing: border-box;
   margin: 0;
   padding: 0;
   font-family: sans-serif;
 }
 .post a {
   color: black;
 }
@media only screen and (min-width: 768px) {
   #content {
     float: left;
     position: relative;
     width: 50%;
     left: 50%;
     margin: 15px 0 60px -304px;
   }
   .post {
     clear: both;
     float: left;
     margin-top: 5%;
     max-width: 608px;
     border: 2px solid black;
     background-color: white;
   }
   .post .profilepicture {
     width: 20vh;
     height: 20vh;
     max-width: 88px;
     max-height: 88px;
     margin: 10px 0 10px 30px;
     float: left;
     border: 1px solid gray;
     border-radius: 100%;
     object-fit: cover;
     object-position: 50%;
     background-color: white;
   }
   .post h3 {
     height: 12%;
     margin: 28px 0 0 30px;
     float: left;
     font-size: 2.5em;
     font-weight: bold;
     background-color: white;
   }
   .post .post-options {
     float: right;
     margin: 20px 35px 0 0;
     font-size: 2vw;
     height: 12%;
     background-color: white;
     /* DROP DOWN MENU */
     position: relative;
     display: inline-block;
   }
   .post .post-options .post-options-content {
     display: none;
     position: absolute;
     background-color: #f9f9f9;
     border: 1px solid lightgray;
     min-width: 250px;
     box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
     padding: 12px 16px;
     z-index: 1
   }
   .post .post-options:hover .post-options-content {
     display: block;
   }
   .post .post-img {
     margin: 0 30px;
     clear: both;
     float: left;
     width: 78vw;
     max-width: 540px;
     /* height: 78vw;
     max-height: 540px; */
     outline: 2px solid black;
     /* object-fit: cover;
     object-position: 50%; */
     background-color: white;
   }
   .post .post-likebtn {
     clear: both;
     float: left;
     margin: 10px 0 10px 30px;
     font-size: 2.3em;
     cursor: pointer;
     border: none;
     outline: none;
     background-color: inherit;
     background-color: white;
   }
   .post .post-likebtn:active{border: none;outline: none;}
   .post .post-likebtn:hover{color:red}
   .post h4 {
     font-size: 3vw;
   }
   .post .likes {
     float: left;
     word-break: break-all;
     background-color: white;
     width: 78vw;
     max-width: 340px;
     margin: 27px 30px 10px 10px;
   }
   .post .post-beschreibung span {
     background-color: inherit;
     font-weight: bold;
   }
   .post .post-beschreibung {
     /* clear: both; */
     float: left;
     word-break: break-all;
     background-color: inherit;
     width: 78vw;
     max-width: 540px;
     margin: 0 30px 15px 30px;
   }
}
@media only screen and (max-width: 768px) {
   #content {
     margin: 0 0 60px 5vw;
     float: left;
     overflow: auto;
     width: 90%;
   }
   #postcontent {
     float: left;
     overflow: auto;
     width: 100%;
   }
   .post {
     float: left;
     margin-top: 5%;
     overflow: auto;
     border: 2px solid black;
     width: 100%;
     background-color: white;
   }
   .post .profilepicture {
     width: 12vw;
     height: 12vw;
     margin: 2% 0 0 5%;
     float: left;
     border: 1px solid gray;
     border-radius: 100%;
     object-fit: cover;
     object-position: 50%;
     background-color: white;
   }
   .post h3 {
     height: 12%;
     margin: 4.7vw 0 0 5%;
     float: left;
     font-size: 5vw;
     background-color: white;
   }
   .post .post-options {
     float: right;
     margin: 3.5% 6% 1% 0;
     font-size: 6vw;
     height: 12%;
     background-color: white;
     /* DROP DOWN MENU */
     position: relative;
     display: inline-block;
   }
   .post .post-options .post-options-content {
     display: none;
     position: absolute;
     right: 0;
     border: 1px solid lightgray;
     background-color: #f9f9f9;
     min-width: 160px;
     box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
     padding: 12px 16px;
     z-index: 1
   }
   .post .post-options:hover .post-options-content {
     display: block;
   }
   .post .post-img {
     margin: 2vw 3.5vw;
     clear: both;
     float: left;
     width: 78vw;
     /* height: 78vw; */
     outline: 2px solid black;
     /* object-fit: cover;
     object-position: 50%; */
     background-color: white;
   }
   .post .post-likebtn {
     clear: both;
     float: left;
     margin: 0 0 2.5% 5%;
     font-size: 4vw;
     cursor: pointer;
     border: none;
     outline: none;
     background-color: inherit;
     background-color: white;
   }
   .post .post-likebtn:active{border: none;outline: none;}
   .post h4 {
     font-size: 3vw;
   }
   .post .likes {
     float: left;
     word-break: break-all;
     background-color: white;
     width: 50vw;
     margin: 1.2vw 3.5vw 10px 2.5vw;
   }
   .post .post-beschreibung span {
     background-color: inherit;
     font-weight: bold;
   }
   .post .post-beschreibung {
     float: left;
     word-break: break-all;
     background-color: inherit;
     width: 78vw;
       margin: 0 3.5vw 1.5vh 3.5vw;
   }
 }
</style>
