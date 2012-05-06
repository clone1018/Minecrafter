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

$route['default_controller'] = "home";
$route['404_override'] = '';

$route['community/chat'] = 'home/chat';

$route['database/:any/:any/post'] = 'database/home/post';
$route['database/:any/:any'] = 'database/home/category';

$route['mod/:any/new'] = 'mods/home/newfile';
$route['mod/:any/edit'] = 'mods/home/edit';
$route['mods/upload'] = 'mods/home/upload';
$route['mod/:any/post'] = 'mods/home/post';
$route['mod/:any'] = 'mods/home/mod';

$route['user/:any'] = 'account/user';

$route['search/:any'] = 'search/index';

$route['servers/add'] = 'servers/home/add';
$route['server/:any/edit'] = 'servers/home/edit';
$route['server/:any/post'] = 'servers/home/post';
$route['server/:any'] = 'servers/home/server';

$route['notifications/subscribe/:any/:any'] = 'notificationscontroller/subscribe';
$route['notifications/unsubscribe/:any/:any'] = 'notificationscontroller/unsubscribe';
$route['notifications/read/:any'] = 'notificationscontroller/read';
$route['notifications/readAll'] = 'notificationscontroller/readAll';

$route['skins/add'] = 'skins/home/add';
$route['skin/:any/edit'] = 'skins/home/edit';
$route['skin/:any/post'] = 'skins/home/post';
$route['skin/:any'] = 'skins/home/skin';

$route['account/auth/:any'] = 'account/auth';

$route['picture/:any'] = 'pictures';


/* End of file routes.php */
/* Location: ./application/config/routes.php */