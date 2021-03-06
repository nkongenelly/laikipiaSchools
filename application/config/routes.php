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
|    example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|    https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|    $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|    $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|    $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:    my-controller/index    -> my_controller/index
|        my-controller/my-method    -> my_controller/my_method
 */
$route['default_controller'] = 'advertiser';
$route['404_override'] = '';
$route['translate_uri_dashes'] = false;

/**
 * Infomoby routes
 */
$route['infomoby/register-business'] = "infomoby/registration/register_business";
$route['infomoby/getfavlistings'] = "infomoby/favouritelistings/favorite_listings";
$route['infomoby/sendactioncard'] = "infomoby/favouritelistings/send_actioncard";

/**
 * Royal Media Service routes
 */
$route['royalmedia/register-service'] = "royalmedia/registration/register_services";
$route['royalmedia/search'] = "royalmedia/allitems/services_search";
$route['royalmedia/items'] = "royalmedia/allitems/items_search";
$route['royalmedia/categories'] = "royalmedia/categories/categories";
$route['royalmedia/category-items'] = "royalmedia/categories/category_items";
$route['royalmedia/purchase-items'] = "royalmedia/categories/purchase_items";
$route['royalmedia/units'] = "royalmedia/categories/units";
$route['royalmedia/allitems'] = "royalmedia/categories/items";

/**
 * Mawingu routes
 */
$route['mawingu/generate-bucket-names'] = "mawingu/merchant_location/generate_bucket_names";
$route['mawingu/remove-throughput-spaces'] = "mawingu/merchant_location/remove_throughput_spaces";
$route['mawingu/update-bucket'] = "mawingu/merchant_location/update_data_throughput_with_location";
$route['mawingu/heatmap'] = "mawingu/merchant_location/populate_heat_map";

/**
 * LaikipiaSchools routes
 */
$route['laikipiaschools/save'] = "laikipiaschools/save/savetodb";
$route['laikipiaschools/schools'] = "laikipiaschools/fetch/getschools";
// $route['default_controller'] = 'pages/view';
// $route['(:any)'] = 'pages/view/$1';

/**
 * Telesales routes
 */
$route['telesales/customers'] = "telesales/telesales/get_customers";
