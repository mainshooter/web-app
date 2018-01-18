<?php
  session_start();
  session_regenerate_id(true);

  ini_set('display_errors', 1);
  error_reporting(E_ALL);

  header('X-Frame-Options: DENY');

  require_once 'config.php';
  require_once 'model/Router.class.php';

  $Router = new Router($GLOBALS['config']['base_url']);
  $Router->set_default_controller('display');
  $Router->proces_router();
?>
