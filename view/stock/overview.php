<h1>Voorraad</h1>
<table class="table">
  <tr>
    <th>ID</th>
    <th>Product naam</th>
    <th>Locatie</th>
    <th>Voorraad</th>
    <th></th>
  </tr>
  <?php

    foreach ($currentStock as $stock) {
      echo "
        <tr>
          <td>{$stock['id']}</td>
          <td>{$stock['product_name']}</td>
          <td>{$stock['location']}</td>
          <td>{$stock['stock']}</td>
          <td><a href='" . siteURL() . "stock/edit/{$stock['id']}'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td>
        </tr>
      ";
    }

  ?>
</table>
