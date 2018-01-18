<?php
  function loadView($viewFile, $vars = false) {
    extract($vars, EXTR_OVERWRITE);
    include APP_PATH . '/view/' . $viewFile;
  }


?>
