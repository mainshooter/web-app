<?php
  require_once APP_PATH . '/libs/model/Language.class.php';

  class displayController {
    private $Language;

    public function __construct() {
      $this->Language = new Language(APP_LANG);
    }

    /**
     * The default method of the controller that present the default view
     */
    public function index() {
      $data['title'] = $this->Language->get('home');
      $data['content'] = $this->Language->get('home_intro_text');

      loadHeader();
      loadView('display/home.php', $data);
      loadFooter();
    }

  }

?>
