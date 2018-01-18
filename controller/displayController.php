<?php
  class displayController {

    /**
     * The default method of the controller that present the default view
     */
    public function index() {
      loadHeader();
      loadView('display/home.php', ['name' => 'Peter']);
      loadFooter();
    }

  }

?>
