<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Routes for admin
$route['admin']         = "backend/dashboard/index";
$route['admin/alumni']  = "backend/users/user/3";
$route['admin/kepsek']  = 'backend/kepsek';
$route['admin/panitia'] = "backend/users/user/2";
$route['admin/survey']  = "backend/survey/detailSurvey";

$route["admin/user/(:any)/import"] = "backend/users/importUser/$1";

// Routes for 'kepsek'
$route['admin/kepsek/create']        = 'backend/kepsek/tambah';
$route['admin/kepsek/(:any)/detail'] = 'backend/kepsek/detail/$1';
$route['admin/kepsek/(:any)/update'] = 'backend/kepsek/update/$1';
$route['admin/kepsek/(:any)/delete'] = 'backend/kepsek/hapus/$1';

// Routes for authentication
$route['logout'] = 'login/logout';

// Routes for 'loker'
$route['admin/loker']               = 'backend/loker/index';
$route['admin/loker/create/(:any)'] = 'backend/loker/create/$1';
// $route['admin/loker/(:any)/detail'] = 'backend/loker/detail/$1';
$route['loker/(:any)/detail']       = 'frontend/loker/detail/$1';
$route['loker/(:any)/update']       = 'frontend/loker/update/$1';
$route['loker/(:any)/delete']       = 'frontend/loker/delete/$1';

// Routes for 'survey'
$route['admin/survey/(:any)/export'] = 'backend/survey/export/$1';

// Additional routes
$route['alumni']                      = "backend/users/alumni";
$route['editProfil/(:any)']           = "backend/users/editProfil/$1";
$route['updateProfil/(:any)/(:any)']  = "backend/users/update/$1/$1";
$route['detailSurvey/(:any)']         = "backend/survey/survei/$1";
$route['lakukanSurvey/(:any)/(:any)'] = "backend/survey/lakukansurvei/$1/$1";
