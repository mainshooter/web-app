<?php

  class displayController {

    /**
     * The default method of the controller that present the default view
     */
    public function index() {
      include 'view/theme/header.php';
      loadView('display/home.php', ['name' => 'Peter']);
      include 'view/theme/footer.php';
    }

  }

?>
