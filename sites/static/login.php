<style>
  #test {
    background-color: black;
    color: white;
  }
</style>

<h1>Einloggen</h1>
<?php echo("".$errorMessage) ?>
<form method="POST" action="?p=profile">
  <br>
  <table>
    <tr><td>Benutzername: </td><td><input name="BName"></td></tr>
    <tr><td>Passwort: </td><td><input name="Passwort" type=password><br></td></tr>
  </table>
  <br>
  <input type=submit name=submit value="Einloggen">
  <br>
  <a href="?p=register">Noch kein Mitglied? Dann registiere dich!</a>
</form>
