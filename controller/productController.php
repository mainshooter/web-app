<?php

  require_once APP_PATH . '/libs/model/Product.class.php';
  require_once APP_PATH . '/controller/appController.php';

  class productController extends appController {
    private $Product;

    public function __construct() {
      parent::__construct();
      $this->Product = new Product();
    }

    public function index() {
      $this->overview();
    }

    protected function overview() {
      $products = $this->Product->getAllProducts();
      if ($products != false) {
        $data['products'] = $products;
        loadHeader();
        loadView('product/product-overview.php', $data);
        loadFooter();
      }
      else {
        $data['message'] = 'We hebben geen producten';
        loadHeader();
        loadView('product/no-product.php', $data);
        loadFooter();
      }
    }

    public function create() {
      $this->FormHandler->setRequired('productName');
      $this->FormHandler->setRequired('productPrice');
      $data['message'] = '';
      if ($this->FormHandler->run() === true) {
        $productName = $this->FormHandler->getPostValue('productName');
        $productPrice = $this->FormHandler->getPostValue('productPrice');

        $result = $this->Product->createProduct($productName, $productPrice);
        $data['message'] = 'Product is toegevoegd';
      }
      loadHeader();
      loadView('product/create-product.php', $data);
      loadFooter();
    }

    public function edit($productID = false) {
      if ($productID != false) {
        $productID = $productID[0];
        $product = $this->Product->getProduct($productID);
        if ($product != false) {
          $data['message'] = '';
          $this->FormHandler->setRequired('productName');
          $this->FormHandler->setRequired('productPrice');
          if ($this->FormHandler->run() === true) {
            // update
            $data['message'] = 'product is geupdate';
            $productName = $this->FormHandler->getPostValue('productName');
            $productPrice = $this->FormHandler->getPostValue('productPrice');
            $this->Product->updateProduct($productName, $productPrice, $productID);
            $product = $this->Product->getProduct($productID);
          }
            $data['product'] = $product;
            loadHeader();
            loadView('product/edit-product.php', $data);
            loadFooter();
        }
        else {
          $data['message'] = 'We hebben dat product niet';
          loadHeader();
          loadView('product/no-product.php', $data);
          loadFooter();
        }
      }
      else {
        $data['message'] = 'We hebben dat product niet';
        loadHeader();
        loadView('product/no-product.php', $data);
        loadFooter();
      }
    }

    public function delete($productID = false) {
      if ($productID != false) {
        $productID = $productID[0];
        if (ISSET($_GET['confirm']) && $_GET['confirm'] == true) {
          // remove
          $this->Product->deleteProduct($productID);
          redirect('product/');
        }
        else {
          // display remove message
          $data['productID'] = $productID;
          loadHeader();
          loadView('product/delete-product.php', $data);
          loadFooter();
        }
      }
      else {
        $data['message'] = 'We hebben dat product niet';
        loadHeader();
        loadView('product/no-product.php', $data);
        loadFooter();
      }
    }

  }


?>
