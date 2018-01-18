</h3><?php echo $message; ?></h3>
<form method="post" action="<?php echo siteURL(); ?>location/edit/<?php echo $location[0]['id']; ?>">
  <br>
  <label>Locatie naam</label><br>
  <input type="text" name="locationName" value="<?php echo $location[0]['location'] ?>" required>

  <br>
  <br>
  <input type="submit" name="addLocation" class="btn btn-info" value="Toevoegen">

</form>
