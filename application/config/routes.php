<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome/gateway/index';
//$route['(:any)'] = 'welcome/gateway/index';

//$route['admin'] = 'login/backend/login_back/index';
//$route['admin/login'] = 'login/backend/login_back/index';

//$route['login'] = 'user/login/index';
//$route['logout'] = 'user/logout';

//$route['artikel/(:any)/(:any)'] = 'post/o/$1/$2';
//$route['artikel/(:any)/(:any)'] = 'Post/o/$1/$2';

//$route['knowledgebase'] = 'post/knowledgebase';
//$route['knowledgebase/informasi'] = 'post/informasi';
//$route['knowledgebase/tutorial'] = 'post/tutorial';

$gate = 'welcome/gateway/index';

$route['memberarea'] = 'welcome/gateway/index';
$route['memberarea/ticket'] = 'welcome/gateway/index';
$route['memberarea/ticket/(:any)'] = 'welcome/gateway/index';
$route['memberarea/profile'] = 'welcome/gateway/index';
$route['memberarea/profile/(:any)'] = 'welcome/gateway/index';
$route['memberarea/setting'] = 'welcome/gateway/index';
$route['memberarea/setting/(:any)'] = 'welcome/gateway/index';

$route['knowledgebase'] = 'welcome/gateway/index';
$route['knowledgebase/tutorial'] = 'welcome/gateway/index';
$route['knowledgebase/informasi'] = 'welcome/gateway/index';

$route['login'] = 'welcome/gateway/index';
$route['logout'] = 'welcome/gateway/index';

$route['artikel'] = 'welcome/gateway/index';
$route['artikel/(:any)/(:any)'] = 'welcome/gateway/index';
//$route['ticket'] = 'ticket/index';


$route['admin'] = 'welcome/gateway/admin';
$route['admin/dashboard'] = 'welcome/gateway/admin';
$route['admin/login'] = 'welcome/gateway/admin';
$route['admin/login/'] = 'welcome/gateway/admin';
$route['admin/logout'] = 'welcome/gateway/admin';
$route['admin/setting/privilege'] = 'welcome/gateway/admin';
$route['admin/setting/profile'] = 'welcome/gateway/admin';
$route['admin/masterdata/user'] = 'welcome/gateway/admin';
$route['admin/unprivileged'] = 'welcome/gateway/admin';
$route['admin/masterdata/group'] = 'welcome/gateway/admin';
$route['admin/masterdata/ticket/priority'] = 'welcome/gateway/admin';
$route['admin/ticket/list'] = 'welcome/gateway/admin';
$route['admin/ticket/(:any)'] = 'welcome/gateway/admin';
$route['admin/log'] = 'welcome/gateway/admin';
$route['admin/test'] = 'welcome/gateway/admin';

//$route['admin/task/list'] = 'welcome/gateway/admin';
$route['admin/task/(:any)'] = 'welcome/gateway/admin';
$route['admin/report'] = 'welcome/gateway/admin';






$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
