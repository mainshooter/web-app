<?php
  require_once APP_PATH . '/libs/model/DatabaseHandler.class.php';
  require_once APP_PATH . '/libs/model/Security.class.php';
  class Location {
    private $DatabaseHandler;
    private $Security;

    public function __construct() {
      $this->DatabaseHandler = new DatabaseHandler();
      $this->Security = new Security();
    }

    /**
     * Gets all of our locations from the db
     * @return [arr] [An assoc array with all results from the db]
     */
    public function getLocations() {
      $sql = "SELECT * FROM location";
      $input = array();

      $result = $this->DatabaseHandler->read_query($sql, $input);

      if (!empty($result)) {
        return($result);
      }
      else {
        return(false);
      }
    }

    /**
     * Adds a location to the db
     * @param [string] $locationName [The name of the location]
     * @return [int] $createdID [The ID of the created location]
     */
    public function addLocation($locationName) {
      $sql = "INSERT INTO location (location) VALUES (:locationName)";
      $input = array(
        "locationName" => $this->Security->check_input($locationName),
      );
      $createdID = $this->DatabaseHandler->execute_query($sql, $input);
      return($createdID);
    }

    /**
     * Gets a location from the database by  locationID
     * @param  [int] $locationID [The id of a location]
     * @return [assoc]             [The result from the db]
     */
    public function getLocation($locationID) {
      $sql = "SELECT * FROM location WHERE id=:locationID";
      $input = array(
        "locationID" => $this->Security->check_input($locationID),
      );

      $result = $this->DatabaseHandler->read_query($sql, $input);
      if (!empty($result)) {
        return($result);
      }
      else {
        return(false);
      }
    }

    /**
     * Updates the location of a location by the location id
     * @param  [int] $locationID   [The ID of the location]
     * @param  [string] $locationName [The new name of the location]
     * @return [type]               [description]
     */
    public function updateLocation($locationID, $locationName) {
      $sql = "UPDATE location SET location=:locationName WHERE id=:locationID";
      $input = array(
        "locationName" => $this->Security->check_input($locationName),
        "locationID" => $this->Security->check_input($locationID),
      );
      $result = $this->DatabaseHandler->execute_query($sql, $input);
    }
  }


?>
