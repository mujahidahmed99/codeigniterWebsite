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
$route['users/login_validation'] = 'users/login_validation';
$route['users/register_validation'] = 'users/register_validation';
$route['pages/logout'] = 'pages/logout';
$route['pages/add_card'] = 'pages/add_card';
$route['pages/add_transaction'] = 'pages/add_transaction';
$route['pages/filter_transaction'] = 'pages/filter_transaction';
$route['pages/filter_chart'] = 'pages/filter_chart';
$route['pages/get_chart_data/(:any)'] = 'pages/get_chart_data/$1/$2';
$route['pages/request_card/(:any)'] = 'pages/request_card/$1';
$route['pages/request_category/(:any)'] = 'pages/request_category/$1';
$route['pages/request_item_transaction/(:any)'] = 'pages/request_item_transaction/$1';
$route['pages/make_card_active/(:any)'] = 'pages/make_card_active/$1';
$route['users/(:any)'] = 'users/view/$1';
$route['default_controller'] = 'welcome';
$route['pages/(:any)'] = 'pages/view/$1';
$route['(:any)'] = 'pages/view/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
