<?php

  require_once APP_PATH . '/libs/model/Language.class.php';
  require_once APP_PATH . '/libs/model/User.class.php';
  require_once APP_PATH . '/libs/model/FormHandler.class.php';

  abstract class appController {
    protected $Language;
    protected $User;
    protected $FormHandler;

    protected function __construct() {
      $this->Language = new Language(APP_LANG);
      $this->User = new User();
      $this->FormHandler = new FormHandler();
    }
  }


?>
