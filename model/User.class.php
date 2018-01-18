<?php
require_once 'model/DatabaseHandler.class.php';
require_once 'model/Security.class.php';

 class User {
   private $Security;
   private $DatabaseHandler;

   private $loginToken;
   private $allowedRoles;

   function __construct() {
     $this->loginToken = 'h79vr29hu3pqhf-249pgae';

     $this->Security = new Security();
     $this->DatabaseHandler = new DatabaseHandler();
   }

   /**
    * [userLogin description]
    * @param  [string] $clientMail     [The mail adress of the client]
    * @param  [string] $clientPassword [The password of the client]
    * @return [boolean]                 [If a login is succesfully we return true else we return false]
    */
   public function userLogin($clientMail, $clientPassword) {
     if ($this->checkIfEmailExists($clientMail) === true) {
       // If we the mail exists

       $clientMail = $this->Security->check_input($clientMail);
       $clientPassword = $this->Security->check_input($clientPassword);

       $orginalHashedPassword = $this->getHashedPasswordFromDatabase($clientMail);
       if ($this->validatePassword($clientPassword, $orginalHashedPassword) === true) {
         // Password match
         $this->logUserIn($clientMail);
         return(true);
       }

       else {
         // passwords don't match
         return(false);
       }
     }

     else {
       // Mail doens't exists
       return(false);
     }
   }

   /**
    * Registers a new user
    * @param  [string] $userMail     [The mail adress of the client we want to register]
    * @param  [string] $userPassword [The password of the client we want to register NOT hassed]
    * @param  [string] $role         [The role we want to give to the client]
    * @return [string]               [The activation key for a client to send it in the mail for a activation]
    */
   public function registerUser($userMail, $userPassword, $role) {
     $hashedPassword = $this->hashPassword($this->Security->check_input($userPassword));

     if ($this->checkIfEmailExists($userMail) === false) {
       // Mail adress doens't exists
       $activationKey = $this->generateActivationKey();
       $sql = "INSERT INTO user (`mail` , `password`, `role`, `activationkey`, `activated`) VALUES (:mail, :password, :role, :activationKey, :activated)";
       $input = array(
         "mail" => $this->Security->check_input($userMail),
         "password" => $this->Security->check_input($hashedPassword),
         "role" => $this->Security->check_input($role),
         "activationKey" => $activationKey,
         "activated" => 0
       );

       $this->DatabaseHandler->execute_query($sql, $input);
       return($activationKey);
     }

     else {
       return(false);
     }
   }

   /**
    * Checks if a mail adress exists
    * @param  [string] $userMailInput [The mail adress we want to check]
    * @return [boolean]                [If the mail adress exists we return true]
    */
   public function checkIfEmailExists($userMailInput) {
     $sql = "SELECT `mail` FROM user WHERE `mail`=:mail";
     $input = array(
       "mail" => $this->Security->check_input($userMailInput)
     );
     $result = $this->DatabaseHandler->count_rows($sql, $input);

     if ($result == 1) {
       return(true);
     }
     else if ($result == 0) {
       return(false);
     }
   }

   /**
    * Sets who has acces to a page
    * As a array
    * @param [array] $allowedRoles [All the roles who are allowed to the page]
    */
   public function setPageAcces($allowedRoles) {
     $this->allowedRoles = $allowedRoles;
   }

   /**
    * Checks if a client has acces to a page
    * @param  boolean $role [When a role is send as a argument we use that role to check if the client has acces]
    * @return [boolean]        [When a client has acces we return true]
    */
   public function checkIfClientHasAcces($role = false) {
     if (ISSET($_SESSION['loginToken'])) {
       if ($_SESSION['loginToken'] === $this->loginToken) {

         if ($role != false) {
           // if we have send a role we compaire them
           if ($role == $this->getUserRole()) {
             return(true);
           }

           else {
             // Not the good role
             return(false);
           }
         }

         else {
           // No allowed role has been send so we use the allowRoles property
           foreach ($this->allowedRoles as $role) {
             if ($role == $this->loginToken) {
               return(true);
               break;
             }

             else {
               $result = false;
             }
           }
         }
       }

       else {
         $result = false;
       }
     }

     else {
       $result = false;
     }
     return($result);
   }

   /**
    * Logs a client out
    * @return [bolean] [Return a true when a client is loged out]
    */
   public function logoutUser() {
     unset($_SESSION);
     return(true);
   }

   /**
    * If a client is logtin we return the userID
    * @return [int] [The ID of the user]
    */
   public function getUserID() {
     if (ISSET($_SESSION['userID'])) {
       return($_SESSION['userID']);
     }

     else {
       return(false);
     }
   }

   /**
    * Gets the mail adress of the user if he is logged in
    * @return [string] [The mail adress of the client]
    */
   public function getUserMail() {
     if (ISSET($_SESSION['userMail'])) {
       return($_SESSION['userMail']);
     }

     else {
       return(false);
     }
   }

   /**
    * Gets the roll of a user
    * @return [string] [The name of the rol of the user]
    */
   private function getUserRole() {
     if (ISSET($_SESSION['userRole'])) {
       return($_SESSION['userRole']);
     }

     else {
       return(false);
     }
   }

   private function generateActivationKey() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
   }

   /**
    * Compairs the password of the client with the hashed password
    * @param  [string] $clientPassword [The not hashed password of the client]
    * @param  [string] $hashedPassword [The hashed password from the user from the db]
    * @return [boolean]                 [Return true if the passwords are the same]
    */
   private function validatePassword($clientPassword, $hashedPassword) {
     if (password_verify($clientPassword, $hashedPassword) === true) {
       return(true);

     }
     else {
       return(false);
     }
   }

   /**
    * Logs a user in
    * By filling in the session variables we need to check if the client is logged in
    * @param  [string] $userMail [The mail adress of the client]
    */
   private function logUserIn($userMail) {
     $userInfo = $this->getUserInfo($userMail);

     $_SESSION['loginToken'] = $this->loginToken;
     $_SESSION['userMail'] = $userMail;

     foreach ($userInfo as $user) {
       $_SESSION['userID'] = $user['userID'];
       $_SESSION['userRole'] = $user['role'];
     }
   }

   /**
    * Gets some user info from the client
    * Contains the ID of the user and to role of them
    * @param  [string] $userMail [The mail adress of the user]
    * @return [arr]           [The result from the db]
    */
   private function getUserInfo($userMail) {
     $sql = "SELECT userID, role FROM user WHERE mail=:clientMail";
     $input = array(
       "clientMail" => $this->Security->check_input($userMail)
     );

     $result = $this->DatabaseHandler->read_query($sql, $input);
     return($result);
   }

   /**
    * Hashes a password
    * @param  [string] $blankPassword [The password we want to hash]
    * @return [string]                [The password but then hashed]
    */
   private function hashPassword($blankPassword) {
     $password = password_hash($blankPassword, PASSWORD_BCRYPT);

     return($password);
   }

   /**
    * Gets the hashed password from a user from the db
    * @param  [string] $userMail [The mail adress of the user]
    * @return [string]           [The hashed password from the db]
    */
   private function getHashedPasswordFromDatabase($userMail) {
     $sql = "SELECT password FROM user where `mail`=:mail";
     $input = array(
       "mail" => $this->Security->check_input($userMail)
     );

     $result = $this->DatabaseHandler->read_query($sql, $input);
     foreach ($result as $key) {
       return($key['password']);
     }
   }

 }

// $user = new User();
// $user->registerNewUser("admin@multiversum.nl", '1234');



?>
