<?php
  require_once APP_PATH . '/libs/model/Language.class.php';

  class displayController {

    public function __construct() {

    }

    /**
     * The default method of the controller that present the default view
     */
    public function index() {
      $Language = new Language(APP_LANG);
      $data['title'] = $Language->get('home');
      $data['content'] = $Language->get('home_intro_text');

      loadHeader();
      loadView('display/home.php', $data);
      loadFooter();
    }

  }

?>
