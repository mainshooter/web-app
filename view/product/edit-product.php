</h3><?php echo $message; ?></h3>
<form method="post" action="<?php echo siteURL(); ?>product/edit/<?php echo $product[0]['id']; ?>">
  <br>
  <label>Product naam</label><br>
  <input type="text" name="productName" value="<?php echo $product[0]['name'] ?>" required>
  <br>
  <label>Product prijs</label><br>
  <input type="number" name="productPrice" value="<?php echo $product[0]['price'] ?>" required>

  <br>
  <br>
  <input type="submit" name="editProduct" class="btn btn-info" value="Opslaan">

</form>
