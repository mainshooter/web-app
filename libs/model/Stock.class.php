<?php
  require_once APP_PATH . '/libs/model/DatabaseHandler.class.php';
  class Stock {
    private $DatabaseHandler;

    public function __construct() {
      $this->DatabaseHandler = new DatabaseHandler();
    }

    public function getAllStock() {
      $sql = "SELECT stock.*, product.name AS product_name, location.location FROM stock JOIN product ON product.id=product_id JOIN location ON location.id=location_id";
      $input = array();

      $result = $this->DatabaseHandler->read_query($sql, $input);

      if (!empty($result)) {
        return($result);
      }
      else {
        return(false);
      }
    }


  }


?>
