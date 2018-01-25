<?php
  require_once APP_PATH . '/libs/model/Security.class.php';

  class Router {
    private $rootPath;
    private $router_request;

    private $default_controller;

    private $controller;
    private $method;
    private $parameters;

    private $Security;

    /**
     * Sets our root path so we can filter the request
     * @param [string] $base_url [the full url of the browser: e.g. http://localhost/]
     */
    public function __construct($base_url) {
      $this->Security = new Security();

      $fullUrl = $_SERVER['REQUEST_URI'];
      $rootPath = $this->get_root_dir($base_url);

      $this->router_request = explode('/',str_replace($rootPath, '', $fullUrl));
    }

    /**
     * Gets the root directory of our project
     * @param  [string] $base_url [The base url of our project]
     * @return [string]           [Our root path wich we can use to make it work]
     */
    private function get_root_dir($base_url) {
      $urlExploded = explode('/', $base_url);
      unset($urlExploded[0]);
      unset($urlExploded[1]);
      unset($urlExploded[2]);

      $urlExploded = array_values($urlExploded);
      foreach ($urlExploded as $url) {
        $this->rootPath = $this->rootPath . '/' . $url;
      }
      return($this->rootPath);
    }

    /**
     * Process the router and goes to the controller if every thign goes well
     */
    public function proces_router() {
      $this->get_controller();
      $this->get_method();
      $this->get_parameters();

      require_once 'controller/' . $this->controller . 'Controller.php';

      $fullControllerName = $this->controller . 'Controller';
      call_user_func_array(array(new $fullControllerName, $this->method),[$this->parameters]);
    }

    public function set_default_controller($controller = false) {
      if ($controller != false && file_exists('controller/' . $controller . 'Controller.php') === true) {
        $this->default_controller = $controller;
      }
      else {
        die('<h1>We don"t know that controller, please check</h1>');
      }
    }

    /**
     * Gets the name of the controller and returns it
     * @return [string] [The name of the controller]
     */
    private function get_controller() {
      if (ISSET($this->router_request[0])) {
        // We have a / after the router
        if ($this->router_request[0] != '') {
          // No empty name
          $this->router_request[0] = lcfirst($this->router_request[0]);
          if (file_exists('controller/' . $this->router_request[0] . 'Controller.php') === true) {
            // We have also that file!
            $this->controller = $this->router_request[0];
          }
          else {
            $this->controller = $this->default_controller;
          }
        }
        else {
          $this->controller = $this->default_controller;
        }
      }
      else {
        $this->controller = $this->default_controller;
      }
      return($this->controller);
    }

    /**
     * Gets the method of the router_request and returns it
     * @return [string] [The name of the method]
     */
    private function get_method() {
      if (ISSET($this->router_request[1])) {
        require_once 'controller/' . $this->controller . 'Controller.php';
        $controllerName = $this->controller . 'Controller';
        if (method_exists(new $controllerName, $this->router_request[1])) {
          $this->method = $this->router_request[1];
        }
        else {
          $this->method = 'index';
        }
      }
      else {
        $this->method = 'index';
      }
    }

    private function get_parameters() {
      if (ISSET($this->router_request[0]) && ISSET($this->router_request[1]) && ISSET($this->router_request[2])) {
        $temp_request = $this->router_request;
        unset($temp_request[0]);
        unset($temp_request[1]);
        $temp_request = array_values($temp_request);

        for ($i=0; $i < count($temp_request); $i++) {
          $this->parameters[] = $this->Security->check_input($temp_request[$i]);
        }
      }
      else {
        // No parameters found
        $this->parameters = '';
      }
    }

  public function set_custom_url($array) {

  }
}


?>
