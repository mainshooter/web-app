<?php
  require_once APP_PATH . '/libs/model/Location.class.php';
  class locationController {
    private $Location;

    public function __construct() {
      $this->Location = new Location();
    }

    public function index() {
      $locations = $this->Location->getLocations();
      if ($locations != false) {
        // We have result
        $data['locations'] = $locations;
        loadHeader();
        loadView('location/overview.php', $data);
        loadFooter();
      }
      else {
        // No result
        loadHeader();
        loadView('location/no-location.php');
        loadFooter();
      }
    }

    public function add() {
      if (ISSET($_POST['locationName'])) {
        $this->Location->addLocation($_POST['locationName']);
        $data['message'] = 'Locatie is toegevoegd';
        loadHeader();
        loadView('location/add-location.php', $data);
        loadFooter();
      }
      else {
        $data['message'] = '';
        loadHeader();
        loadView('location/add-location.php', $data);
        loadFooter();
      }
    }

    public function edit($locationID = false) {
      if ($locationID != false) {
        if (ISSET($_POST['locationName'])) {
          // We have form submit
          $this->Location->updateLocation($locationID[0], $_POST['locationName']);

          $location = $this->Location->getLocation($locationID[0]);
          $data['location']= $location;
          $data['message'] = 'De locatie is geupdate';
          loadHeader();
          loadView('location/edit-location.php', $data);
          loadFooter();
        }
        else {
          $location = $this->Location->getLocation($locationID[0]);
          $data['location']= $location;
          $data['message'] = '';
          loadHeader();
          loadView('location/edit-location.php', $data);
          loadFooter();
        }
      }
    }

    public function delete($locationID = false) {
      if ($locationID != false) {
        if (ISSET($_GET['confirm']) && $_GET['confirm'] == true) {
          // Delete location and redirect to the overview
          $deleteLocation = $this->Location->deleteLocation($locationID[0]);
          redirect('location/');
        }
        else {
          // Present confirm to delete the location
          $locationID = $locationID[0];
          $data['locationID'] = $locationID;
          loadHeader();
          loadView('location/delete-location.php', $data);
          loadFooter();
        }
      }
    }
  }
?>
