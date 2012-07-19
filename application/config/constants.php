<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
 * Authentication roles
 */
define('AUTH_TABLET', 'tablet');
define('AUTH_MOBILE', 'mobile');
define('AUTH_ADMIN', 'admin');
define('AUTH_SUPER_ADMIN', 'super_admin');

/*
 * Error messages
 */
define('ERROR_ROLE', 'You dont have the right permissions to access this resource!');
define('ERROR_NO_URL_IN_POST', "No url has been specified in the POST body, add an url with 'url' as key.");
define('ERROR_NO_TURTLE_ID_IN_POST', "No turtle id has been specified in the POST body, add it wich 'turtle' as key.");
define('ERROR_NO_MESSAGE_IN_POST', "No message has been specified in the POST body, add it with 'message' as key");
define('ERROR_NO_ACTION_IN_POST', "No action has been specified in the POST body, add it with 'action' as key");
define('ERROR_NO_TURTLES', "There are no turtles linked to that infoscreen");
define('ERROR_NO_INFOSCREEN',"The infoscreen linked to your token does not exist");
define('ERROR_NO_OWNERSHIP_SCREEN', "You don't own this screen!");
define('ERROR_NO_PIN', "No pincode has been specified in the POST body, add it with 'pin' as key");
define('ERROR_PIN_NOT_NUM', "The pincode you provided is not numeric!");
define('ERROR_WRONG_PIN', "The pincode you provided is wrong!");
define('ERROR_NO_USERNAME', "No username specified in the POST body, add it with 'username' as key");
define('ERROR_NO_PASSWORD', "No password specified in the POST body, add it with 'password' as key");
define('ERROR_WRONG_USERNAME_PASSWORD', "The given username or password is wrong");
define('ERROR_ACTION_DOES_NOT_EXIST', "This resource/action does not exist");
define('ERROR_DONT_MESS_WITH_KEY', "Your dedicated key is wrong, stop trying to be a tablet");


/*
 * Limit of token tables (cleanup of expired tokens will happen when this limit is reached)
 */
define('TOKEN_TABLE_LIMIT', 0);

/* End of file constants.php */
/* Location: ./application/config/constants.php */