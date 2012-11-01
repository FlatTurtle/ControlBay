<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['404_override'] = '';
$route['default_controller'] = 'api/infoscreens';
$route['auth/(.*)'] = 'auth/$1';
// Routes for aliases
$route['(.*)/view'] = 'api/redirect_view/$1';
$route['(.*)/panes'] = 'api/panes/$1';
$route['(.*)/panes/(.*)'] = 'api/pane/$1/$2';
$route['(.*)/turtles'] = 'api/turtles/$1';
$route['(.*)/turtles/(.*)'] = 'api/turtle/$1/$2';
$route['(.*)/jobs'] = 'api/jobs/$1';
$route['(.*)/plugins/(.*)/(.*)'] = 'plugin/$2/$3/$1';
$route['(.*)/plugins/(.*)/*'] = 'plugin/$2/index/$1';
$route['(.*).json'] = 'api/export_json/$1';
$route['(.*)'] = 'api/infoscreen/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */