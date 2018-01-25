<?php

  require_once APP_PATH . '/libs/model/FormHandler.class.php';

  abstract class parentController {
    protected $FormHandler;
    protected function __construct() {
      $this->FormHandler = new FormHandler;
    }
  }



?>
