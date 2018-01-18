<?php
  require_once 'model/Security.class.php';

  class FileUploader {
    private $Security;

    private $allowedFileTypes;
    private $saveLocation;


    public function __construct() {
      $this->Security = new Security();
    }

    /**
     *
     * @param  [arr] $file [The uploaded file]
     * @return [boolean]       [If everything went well we return true]
     */
    public function uploadFile($file) {
      if ($this->checkIfDirectoryExists()) {
        if ($this->checkIfFileTypeIsAllowed($file['type'])) {
          $uploadResult = move_uploaded_file($file['tmp_name'], $this->saveLocation . $file['name']);
          return($uploadResult);
        }

        else {
          // Not allowed file type
          return(false);
        }
      }

      else {
        // Directory doesn't exists
        return(false);
      }
    }

    /**
     * Sets the allowed file types
     * @param [string / array] $allowedFileTypes [a string if we want to allow all file types and a array with all file types we want to allow]
     */
    public function setAllowedFileTypes($allowedFileTypes) {
      $this->allowedFileTypes = $allowedFileTypes;
    }

    /**
     * Sets the save location of the file
     * @param [string] $location [The FULL path location of the directory we want to save the file in]
     */
    public function setSaveLocation($location) {
      $this->saveLocation = $this->Security->check_input($location);
    }

    /**
     * Checks if a file exists
     * FUNCTION CAN ONLY BE USED AFTER setSaveLocation
     * @param  [string] $fileName [The name of the uploaded file]
     * @return [boolean]           [If the file exists we return true]
     */
    public function checkIfFileExists($fileName) {
      if (file_exists($this->saveLocation . $fileName)) {
        return(true);
      }

      else {
        return(false);
      }
    }

    /**
     * Checks if a directory exists
     * @return [boolean] [Of we found the directory we return true]
     */
    private function checkIfDirectoryExists() {
      if (file_exists($this->saveLocation) === true) {
        return(true);
      }

      else {
        return(false);
      }
    }

    /**
     * Checks if a file type is allowed
     * @param  boolean $fileType [containing the file type of the uploading file]
     * @return [boolean]            [If the file type is allowed we return true]
     */
    private function checkIfFileTypeIsAllowed($fileType = false) {
      if ($this->allowedFileTypes === '*') {
        return(true);
      }

      else if (is_array($this->allowedFileTypes)){
        foreach ($this->allowedFileTypes as $fileTypes) {
          if ($fileTypes === $fileTypes) {
            // Same file type
            return(true);
            break;
          }
        }
        // If we didn't found anything else
        return(false);
      }

      else {
        // No other result we stop
        return(false);
      }
    }



  }
  // application/javascript
  // application/json
  // application/x-www-form-urlencoded
  // application/xml
  // application/zip
  // application/pdf
  // application/sql
  // application/msword (.doc)
  // application/vnd.ms-excel (.xls)
  // application/vnd.openxmlformats-officedocument.spreadsheetml.sheet (.xlsx)
  // application/vnd.ms-powerpoint (.ppt)
  // application/vnd.openxmlformats-officedocument.presentationml.presentation (.pptx)
  // audio/mpeg
  // audio/vorbis
  // multipart/form-data
  // text/css
  // text/html
  // text/csv
  // text/plain
  // image/png
  // image/jpeg
  // image/gif
  // All file types

?>
