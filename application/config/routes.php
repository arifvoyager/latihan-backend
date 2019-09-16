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

$route['default_controller']    = "Home";
$route['404_override']          = 'Home';

//Custome Root ***************************************************************
$route['dwpanel']                       = 'backend/cpanelx';
$route['jpanel']                        = 'backend/cpanelx';
$route['jpanel/(:any)/(:any)']          = 'backend/$1/$2';
$route['jpanel/(:any)']                 = 'backend/$1';
$route['cms']                           = 'backend/cpanelx';
$route['cms/(:any)/(:any)']             = 'backend/$1/$2';
$route['cms/(:any)']                    = 'backend/$1';

$route['sendMessage']          = $route['default_controller'].'/sendMessage';
$route["$1"]                   = '$1';
$route["$1/$2"]                = '$1/$2';
$route["search?(:any)"]        = 'mainpage/search';

/**
$route["standar-pedoman?(:any)"]          = "page/download";
$route["page?(:any)"]          = "page/statis";
$route["about?(:any)"]         = "page/about";
$route["tentang?(:any)"]       = "page/about";
$route["mitra?(:any)"]         = "page/partners";
$route["partners?(:any)"]      = "page/partners";
$route["acara?(:any)"]         = "page/events";
$route["events?(:any)"]        = "page/events";
$route["news?(:any)"]          = "page/news";
$route["berita?(:any)"]        = "page/news";
$route["contact?(:any)"]       = "page/contact";
$route["kontak?(:any)"]        = "page/contact";
$route["organisasi?(:any)"]    = "page/organisasi";
$route["organizations?(:any)"] = "page/organisasi";
$route["gallery?(:any)"]       = "page/gallery";
$route["galeri?(:any)"]        = "page/gallery";
**/
/* End of file routes.php */
/* Location: ./application/config/routes.php */