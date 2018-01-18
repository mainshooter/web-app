<?php
  require_once APP_PATH . '/config.php';
  require_once 'Security.class.php';

  class DatabaseHandler {
    private $Security;

    private $conn = null;

    private $server_ip;
    private $server_port = 3066;
    private $database_name;
    private $username;
    private $password;

    /**
     * Runs when we instance the class
     * Sets the ip, port, database name and the login credentials
     */
    public function __construct() {
      $this->Security = new Security();
      $this->set_server_ip($GLOBALS['config']['db-server_ip']);
      $this->set_server_port($GLOBALS['config']['db-server_port']);
      $this->set_database_name($GLOBALS['config']['db-database_name']);
      $this->set_login_credentials($GLOBALS['config']['db-username'], $GLOBALS['config']['db-password']);
      $this->start_connection();
    }

    /**
     * Sets the server ip adress of the database we going to use
     * @param string $ip The ip of the database server
     */
    public function set_server_ip($ip) {
      $this->server_ip = $this->Security->check_input($ip);
      return($this->server_ip);
    }

    /**
     * Sets the server port for the database connection
     * @param int $port The port of the database is listning to
     */
    public function set_server_port($port) {
      $this->server_port = $this->Security->check_input($port);
      return($this->server_port);
    }

    /**
     * Sets the name of the database
     * @param string $database_name The name of the db
     */
    public function set_database_name($database_name) {
      $this->database_name = $this->Security->check_input($database_name);
      return($this->database_name);
    }
    /**
     * Sets the username and password for the database connection
     * @param string $username the username for the database connection
     * @param string $password the password for the database connection
     */
    public function set_login_credentials($username, $password) {
      $this->username = $this->Security->check_input($username);
      $this->password = $this->Security->check_input($password);

      return([$this->username, $this->password]);
    }
    /**
     * Starts the database connection connection
     */
    public function start_connection() {
      if ($this->check_if_database_credentials_are_filled_in() === true) {
        try {
          $this->conn = new PDO("mysql:host=$this->server_ip;port=$this->server_port;dbname=$this->database_name", $this->username, $this->password);
          // set the PDO error mode to exception
          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
          // To fix limit issue with prepared statement

        } catch (Exception $e) {
          die("<h1>NO database connection!</h1>");
        }

      }
      else {
        die('<h1>No Database filled in</h1>');
      }
    }

    public function execute_query($sql, $input) {
      try {
        $query = $this->conn->prepare($sql);
        $query->execute($input);
        $row = $query->rowCount(PDO::FETCH_ASSOC);
        $lastID = $this->conn->lastInsertId();
        return($lastID);
      } catch (Exception $e) {
        return ("Couldn't execute query: " . $e->getMessage());
      }

    }

    public function read_query($sql, $input) {
      try {
        $query = $this->conn->prepare($sql);
        $query->execute($input);

        $row = $query->fetchAll(PDO::FETCH_ASSOC);
        return($row);

      } catch (Exception $e) {
        return ("Couldn't read: " . $e->getMessage());
      }

    }

    public function count_rows($sql, $input) {
      try {
        $query = $this->conn->prepare($sql);
        $query->execute($input);

        $count = $query->rowCount();
        return($count);
      } catch (Exception $e) {
        return ("Couldn't count the rows: " . $e->getMessage());
      }

    }

    private function check_if_database_credentials_are_filled_in() {
      if (!empty($this->server_ip) && !empty($this->server_port) && !empty($this->database_name) && !empty($this->username)) {
        return(true);
      }
      else {
        return(false);
      }
    }

    public function __destruct() {
      $this->conn = null;
    }
  }
?>
