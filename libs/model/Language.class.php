<?php

  class Language {
    private $language;

    public function __construct($lang) {
      if ($this->checkIfLanguageExists($lang) === true) {
        $this->language = $lang;
        require_once APP_PATH . '/language/' . $lang . '.php';
      }
      else {
        require_once APP_PATH . '/language/' . 'nl.php';
        $this->language = 'nl';
      }
      $this->language = $lang;
    }

    private function checkIfLanguageExists($lang) {
      if (file_exists(APP_PATH . '/language/' . $lang)) {
        return(true);
      }
      else {
        return(false);
      }
    }

    public function get($key) {
      if (ISSET($this->language[$key])) {
        return($this->language[$key]);
      }
      else {
        return(false);
      }
    }
  }


?>
