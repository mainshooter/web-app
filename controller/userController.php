<?php
  require_once APP_PATH . '/libs/model/User.class.php';
  require_once APP_PATH . '/libs/model/FormHandler.class.php';

  class userController {
    private $User;
    private $FormHandler;

    public function __construct() {
      $this->User = new User();
      $this->FormHandler = new FormHandler();
    }

    public function index() {
      $this->login();
    }

    public function login() {
      $this->FormHandler->setRequired('userMail');
      $this->FormHandler->setRequired('userPassword');

      if ($this->FormHandler->run() === true) {
        // login
        $mail = $this->FormHandler->getPostValue('userMail');
        $password = $this->FormHandler->getPostValue('userPassword');
        if ($this->User->verifyLogin($mail, $password) === true) {
          redirect('product/');
        }
        else {
          // login with error
          $data['error'] = 'Geen goede combinatie';
          loadHeader();
          loadView('user/login.php', $data);
          loadFooter();
        }
      }
      else {
        $data['error'] = '';
        loadHeader();
        loadView('user/login.php');
        loadFooter();
      }
    }
  }


?>
