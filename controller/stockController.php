<?php
  require_once APP_PATH . '/libs/model/Location.class.php';
  require_once APP_PATH . '/libs/model/Product.class.php';
  require_once APP_PATH . '/libs/model/Stock.class.php';

  require_once APP_PATH . '/controller/appController.php';

  class stockController extends appController {
    private $Product;
    private $Location;
    private $Stock;

    public function __construct() {
      parent::__construct();
      $this->Product = new Product();
      $this->Location = new Location();
      $this->Stock = new Stock();
    }

    public function index() {
      $this->overview();
    }

    public function overview() {
      if ($this->User->checkIfClientIsLogedin()) {
        $currentStock = $this->Stock->getAllStock();
        if ($currentStock != false) {
          $data['currentStock'] = $currentStock;
          loadCompleteView('stock/overview.php', $data);
        }
        else {
          // No stock
          loadCompleteView('stock/no-stock.php');
        }
      }
      else {
        redirect('/');
      }
    }

    public function edit($stockID = false) {
      if ($stockID != false) {
        if ($this->User->checkIfClientIsLogedin()) {

        }
        else {
          redirect('/stock/');
        }
      }
      else {
        redirect('/');
      }
    }
  }


?>
