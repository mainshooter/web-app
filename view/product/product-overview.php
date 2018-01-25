<h2>Producten</h2>
<table class="table">
  <tr>
    <th>Product naam</th>
    <th>Product prijs</th>
    <th></th>
  </tr>
  <?php
    foreach ($products as $product) {
      echo "
        <tr>
          <td>{$product['name']}</td>
          <td>{$product['price']}</td>
          <td>
            <a href='" . siteURL() . "product/edit/{$product['id']}'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a>
            <a href='" . siteURL() . "product/delete/{$product['id']}'><i class='fa fa-trash-o' aria-hidden='true'></i></a>
          </td>
        </tr>
      ";
    }
  ?>
</table>
<button type="button" class="btn btn-primary"><a href="<?php echo siteURL() ?>product/create/">Nieuw product</a></button>
