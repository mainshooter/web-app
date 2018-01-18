<?php
  require_once 'model/DatabaseHandler.class.php';

  class displayController {

    /**
     * The default method of the controller that present the default view
     */
    public function index() {
      include 'view/theme/header.php';
      include 'view/theme/footer.php';
    }

  }

?>
