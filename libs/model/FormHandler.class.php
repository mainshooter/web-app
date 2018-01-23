<?php
  require_once 'Security.class.php';

  class FormHandler {
    private $Security;
    private $keys;

    public function __construct() {
      $this->Security = new Security();
    }

    /**
     * Sets a post request key who is required for the form
     * @param [string] $keyname [The name of the post key]
     */
    public function setRequired($keyname) {
      $this->keys[] = $this->Security->check_input($keyname);
    }

    /**
     * Runs the formhandler and checks if all keys are set and valid
     * @return [boolean] [Return truw if everything went well]
     */
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

    /**
     * Gets the value from a post cleaned
     * @param  [string] $postKey [The name of the post key]
     * @return [string]          [The result sanitized]
     */
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
