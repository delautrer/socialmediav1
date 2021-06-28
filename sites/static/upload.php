<style>

</style>
<h1>Bild Posten</h1>
<!-- <?php echo("UID: ".$_SESSION['UID']) ?> -->
<form method="post" action="?p=profile" enctype="multipart/form-data">
  <input type="hidden" name="size" value="1000000">
    <input type="file" accept=".jpg,.jpeg,.png" name="image">
    <br>
    <textarea name="image_beschreibung" placeholder="Sag was zu deinem Bild! :D"></textarea>
    <br>
    <button type="submit" name="upload">Hochladen</button>
</form>
