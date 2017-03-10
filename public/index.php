<?php
//error_reporting(E_ALL);
ini_set('display_errors', 0);
//ini_set('error_reporting', E_ALL);
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));
ini_set('xdebug.var_display_max_depth', 5);
        ini_set('xdebug.var_display_max_children', 256);
        ini_set('xdebug.var_display_max_data', 1024);
// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server') {
    $path = realpath(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if (__FILE__ !== $path && is_file($path)) {
        return false;
    }
    unset($path);
}

define('BASE_PATH', realpath(dirname(__DIR__)));
define('PUBLIC_PATH', BASE_PATH.'/public');
define('IMAGE_PATH', '');
define('MATRIMONIAL_IMAGE_PATH','/matrimonialImages/profileimages/');
define('EVENTS_IMAGE_PATH',PUBLIC_PATH.'/EventsImages/profileimages/');
define('SUBEVENTS_IMAGE_PATH',PUBLIC_PATH.'/SubeventsImages/profileimages/');
define('EVENTS_IMAGE_THUMB_PATH',PUBLIC_PATH.'/EventsImages/thumb/100x100/');
define('SUBEVENTS_IMAGE_THUMB_PATH',PUBLIC_PATH.'/SubeventsImages/thumb/100x100/');

define('EVENTS_IMAGE_THUMB_PATH_FRONT_THUMB','/EventsImages/thumb/100x100/');
define('EVENTS_IMAGE_THUMB_PATH_FRONT','/EventsImages/');

// Setup autoloading satya
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
