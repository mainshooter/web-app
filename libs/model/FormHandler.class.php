<?php
  require_once 'Security.class.php';

  class FormHandler {
    private $Security;
    private $keys;

    public function __construct() {
      $this->Security = new Security();
    }

    public function setRequired($keyname) {
      $this->keys[] = $this->Security->check_input($keyname);
    }

    public function run() {
      if (!empty($this->keys)) {
        foreach ($this->keys as $key) {
          if (ISSET($_POST[$key]) === true && empty($_POST[$key]) === false) {
            $result = true;
          }
          else {
            return(false);
          }
        }
        return($result);
      }
      else {
        return(false);
      }
    }

    public function getPostValue($postKey) {
      if (ISSET($_POST[$postKey]) === true) {
        $result = $this->Security->check_input($_POST[$postKey]);
        return($result);
      }
      else {
        return(false);
      }
    }

  }


?>
