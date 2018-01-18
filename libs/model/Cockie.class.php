<?php
require_once 'model/Security.class.php';

  class cookie {
    var $cookieName;

    /**
     * Sets the coockieName as a global variable
     * @param [type] $cookieName [description]
     */
    public function __construct($cookieName) {
      $S = new Security();
      $coockieName = $S->checkInput($cookieName);
      $this->cookieName = $coockieName;
    }


    /**
     * Creates a coockie
     * @return [boolean] [Returns on succes true on fail a false]
     */
    public function createCookie() {
      if (!$this->checkIfCoockieExists()) {
        setcookie($this->cookieName);
        return(true);
      }
      else {
        return(false);
      }

    }

    /**
     * Reads a cockie by the coockie name
     * @return [string / array] [Returns the value, values or array from a coockie]
     */
    public function readCookie() {
      if ($this->checkIfCoockieExists()) {
        return($_COOKIE[$this->cookieName]);
      }

      else {
        return(false);
      }

    }


    /**
     * Updates a coockie
     * @param  [string] $index [The index name of the arr we want to add]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    public function updateCoockie($index, $value) {
      if ($this->checkIfCoockieExists()) {
        $_COOCKIE[$this->coockieName][$index] = $value;
        return(true);
      }

      else {
        return(false);
      }
    }


    /**
     * Checks if a coockie exists already
     * @param  [string] $coockieName [The name of the coockie]
     * @return [boolean]              [On succes it returns a true]
     */
    public function checkIfCoockieExists() {
      if (ISSET($_COOKIE[$this->cookieName])) {
        return(true);
      }

      else {
        return(false);
      }
    }


    /**
     * Delets a coockie
     * @return [boolean]    [On succes it returns true or false on fails]
     */
    public function deleteCookie() {
      if ($this->checkIfCoockieExists()) {
        unset($_COOKIE[$this->cookieName]);
        return(true);
      }

      else {
        return(false);
      }

    }
  }


?>
