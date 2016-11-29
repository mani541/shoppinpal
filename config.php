<?php
/**
DB and FB Details
 */

require_once 'messages.php';

//site specific configuration declartion
define( 'BASE_PATH', 'http://localhost/shoppinpal_login/index.php');
define( 'DB_HOST', 'localhost' );
define( 'DB_USERNAME', 'root');
define( 'DB_PASSWORD', '');
define( 'DB_NAME','shoppinpal');


//Facebook App Details
define('FB_APP_ID', '209539872824683');
define('FB_APP_SECRET', '96daac1630f3568f059e6dc62c80a853');
define('FB_REDIRECT_URI', 'http://localhost/shoppinpal_login/');


function __autoload($class)
{
	$parts = explode('_', $class);
	$path = implode(DIRECTORY_SEPARATOR,$parts);
	require_once $path . '.php';
}
