<?php
  require_once APP_PATH . '/libs/model/DatabaseHandler.class.php';

  class User {
    private $DatabaseHandler;

    public function __construct() {
      $this->DatabaseHandler = new DatabaseHandler();

      if (session_status() != 2) {
        die('<h1>No Sessions</h1>');
      }
    }

    public function getUsers() {
      $sql = "SELECT * FROM user";
      $input = array();

      $result = $this->DatabaseHandler->read_query($sql, $input);
      if (!empty($result)) {
        return($result);
      }
      else {
        return(false);
      }
    }

    public function verifyLogin($mail, $password) {
      $userID = $this->getUserID($mail);
      if ($userID != false) {
        if ($this->verifyPassword($userID, $password)) {
          $_SESSION['user']['mail'] = $mail;
          return(true);
        }
      }
      else {
        return(false);
      }
    }

    public function checkIfClientIsLogedin() {
      if (ISSET($_SESSION['user']['mail'])) {
        return(true);
      }
      return(false);
    }

    public function clientLogout() {
      if ($this->checkIfClientIsLogedin()) {
        unset($_SESSION['user']);
        return(true);
      }
      else {
        return(false);
      }
    }

    public function registerNewUser($mail, $password) {
      $hashedPassword = $this->hashPassword($password);

      $sql = "INSERT INTO user (email, password) VALUES (:mail, :password)";
      $input = array(
        "mail" => $mail,
        "password" => $password,
      );

      $userID = $this->DatabaseHandler->execute_query($sql, $input);
    }

    private function verifyPassword($userID, $password) {
      $sql = "SELECT password FROM user WHERE id=:userID";
      $input = array(
        "userID" => $userID,
      );

      $result = $this->DatabaseHandler->read_query($sql, $input);
      if (!empty($result)) {
        $hashedPassword = $result[0]['password'];
        if (password_verify($password, $hashedPassword)) {
          return(true);
        }
        else {
          return(false);
        }
      }
      else {
        return(false);
      }
    }

    private function getUserID($mail) {
      $sql = "SELECT id FROM user WHERE email=:mail LIMIT 1";
      $input = array(
        "mail" => $mail,
      );

      $result = $this->DatabaseHandler->read_query($sql, $input);
      if (count($result) == 1) {
        return($result[0]['id']);
      }
      else {
        return(false);
      }
    }

    private function hashPassword($blankPassword) {
      $hashedPassword = password_hash($blankPassword, PASSWORD_DEFAULT);
      return($hashedPassword);
    }

  }


?>
