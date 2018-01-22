<table class="table">
  <tr>
    <th>ID</th>
    <th>Naam</th>
    <th></th>
  </tr>
  <?php

  foreach ($locations as $location) {
    echo "
      <tr>
        <td>{$location['id']}</td>
        <td>{$location['location']}</td>
        <td>
          <a href='" . siteURL() . "location/edit/{$location['id']}'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a>
          <a href='" . siteURL() . "location/delete/{$location['id']}'><i class='fa fa-trash-o' aria-hidden='true'></i></a>
        </td>
      <tr>
    ";
  }

  ?>
</table>
<button type="button" class="btn btn-primary"><a href="<?php echo siteURL() ?>location/add/">Nieuwe locatie</a></button>
