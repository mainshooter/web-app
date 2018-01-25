<?php
  require_once APP_PATH . '/libs/model/DatabaseHandler.class.php';


  class Product {

    private $DatabaseHandler;

    public function __construct() {
      $this->DatabaseHandler = new DatabaseHandler();
    }

    public function getAllProducts() {
      $sql = "SELECT * FROM product";
      $input = array();

      $result = $this->DatabaseHandler->read_query($sql, $input);
      if (!empty($result)) {
        return($result);
      }
      else {
        return(false);
      }
    }

    public function createProduct($productName, $productPrice) {
      $sql = "INSERT INTO product (name, price) VALUES (:productName, :productPrice)";
      $input = array(
        "productName" => $productName,
        "productPrice" => $productPrice
      );

      $result = $this->DatabaseHandler->execute_query($sql, $input);
      return($result);
    }


    public function getProduct($productID) {
      $sql = "SELECT * FROM product WHERE product.id = :productID";
      $input = array(
        "productID" => $productID,
      );

      $result = $this->DatabaseHandler->read_query($sql, $input);
      if (!empty($result)) {
        return($result);
      }
      else {
        return(false);
      }
    }

    public function updateProduct($productName, $productPrice, $productID) {
      $sql = "UPDATE product SET name=:productName, price=:productPrice WHERE product.id=:productID";
      $input = array(
        "productName" => $productName,
        "productPrice" => $productPrice,
        "productID" => $productID
      );
      $this->DatabaseHandler->execute_query($sql, $input);
    }

    public function deleteProduct($productID) {
      $sql = "DELETE FROM product WHERE product.id=:productID";
      $input = array(
        "productID" => $productID
      );

      $this->DatabaseHandler->execute_query($sql, $input);
    }

  }


?>
