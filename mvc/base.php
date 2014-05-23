<?php

define('EXT', '.php');
define('DOCROOT', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);


$system      = 'system';
$application = 'app';

 
if ( ! is_dir($application) AND is_dir(DOCROOT.$application)){
      $application = DOCROOT.$application;
}
 
if ( ! is_dir($system) AND is_dir(DOCROOT.$system)){
    $system = DOCROOT.$system;
}

define('APPPATH'   , realpath($application).DIRECTORY_SEPARATOR);
define('SYSPATH'   , realpath($system).DIRECTORY_SEPARATOR);
define('THEMEURL'  , get_template_directory_uri().DIRECTORY_SEPARATOR);
define('THEMEPATH' , get_template_directory().DIRECTORY_SEPARATOR);

unset($application, $modules, $system);




 require_once(SYSPATH . 'lib/ClassAutoloader.php');

 $autoloader = new ClassAutoloader();
// $core       = new Core();
 $ccp        = new CustomPostTypes();

?>