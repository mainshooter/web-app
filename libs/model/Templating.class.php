<?php

  class Templating {
    public $templateContent;

    /**
     * Gets the template and place it in the property
     * A template file must and on .tpl
     * @param  string/boolean $location [With the location of the file]
     * @return [string / boolean]            [A error if something goes wrong / on succes]
     */
    public function getTemplateContent($fileLocation = false) {
      if ($fileLocation != false) {
        if (file_exists($fileLocation)) {
          $this->templateContent = file_get_contents($fileLocation);
          return(true);
        }

        else {
          return('File doesn"t exists');
        }

      }

      else {
        return('No location has been given');
      }
    }
  }

  /**
   * Replace a template tag as follow: {site-title} with the good content from te array
   * $array = array(
   *    'site-title' => 'framework-samebestdevelopment'
   *  );
   * @param  [arr] $tags [With the key as the tag and the value as the new content]
   * @return [string/ boolean]   [a error/ a true when succesed]
   */
  public function replaceTemplateTags($tags) {
    if (!empty($tags)) {
      foreach ($tags as $key => $value) {
        $key = str_replace(' ', '', $key);
        $this->templateContent = str_replace('{ ' . $key . ' }', $value, $this->templateContent);
        $this->templateContent = str_replace('{' . $key . '}', $value, $this->templateContent);
      }
      return(true);
    }

    else {
      return('No arr array has been given');
    }
  }

  /**
   * Returns the procesed template
   * @return [string] [The proced template]
   */
  public function getfinishedTemplate() {
    return($this->templateContent);
  }



?>
