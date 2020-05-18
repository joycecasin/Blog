<?php
// Constanten declareren om de site root te bepalen, locatie van de includes map en de locatie van de image map
defined('DS')? null : define('DS', DIRECTORY_SEPARATOR);
define('SITE_ROOT', DS . 'wamp64' . DS . 'www' . DS . 'blogoop');
defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT.DS.'admin' . DS.'includes');
defined('IMAGES_PATH') ? null : define('IMAGES_PATH', SITE_ROOT.DS.'admin' . DS.'img');

require_once ("functions.php");
require_once ("config.php");
require_once ("Database.php");
require_once ("Db_object.php");
require_once (INCLUDES_PATH . DS . "User.php");
require_once (INCLUDES_PATH . DS . "Photo.php");
require_once ("Session.php");
require_once (INCLUDES_PATH . DS . "Comment.php");
require_once (INCLUDES_PATH . DS . "Paginate.php");

?>