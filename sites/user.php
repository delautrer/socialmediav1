<style>
  #memberlist {
    display: table;
  }
  #memberlist input {
    display: inline-table;
    font-size: 40px;
  }
  img {
      width: 50px;
      height: 50px;
      border-radius: 100%;
      object-fit: cover;
      object-position: 50%;
      background-color: gray;
      border: 2px solid lightgray;
  }
</style>
<h1>Suchergbnisse...</h1>
<?php
  if(isset($_POST['search'])){
    header("Location: ?p=user&search=" . $_POST['search']);
  }else
  if(isset($_GET['search'])){
    $searchfor = $_GET['search'];
    $sql = "SELECT * FROM `user` WHERE BName LIKE '%{$searchfor}%'";
    $abfrage = mysqli_query($verbindung, $sql);
    echo"<div id='memberlist'>";
    if(mysqli_num_rows($abfrage) > 0){
      echo "<table>";
      while($user = mysqli_fetch_assoc($abfrage)){
        if($user['Aktiviert'] == 1){
?>
        <table>
          <tr>
            <td>
              <img class="profilepicture" src="upload/<?php echo $user['ProBild']; ?>" alt=":/">
            </td>
            <td>
              <form action="?p=profile&suid=<?php echo"".$user['UID'] ?>" method="post">
                <input type="hidden" value="<?php echo"".$user['UID'] ?>" name="suid" />
                <input type="submit" name="submit" value="<?php echo"".$user['BName']?>">
              </form>
            </td>
          </tr>
        </table>
<?php   }
      }
      echo "</table>
            </div>";
    }else {
      echo "<br><br><h4>Wir konnten leider von \"".$searchfor ."\" in unserer Datenbank finden! :(</h4>";
    }
  }

 ?>
