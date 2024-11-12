<?php 
session_start();
// require_once 'database.php';
// require_once 'controllers/articlesController.php';

// $controller = new ArticlesController($connection); // Initialize the controller with the database connection

require  'vendor/autoload.php';
require 'app/Router.php';

$dotenv=Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Router();

// Register routes for multiple controllers with standard CRUD operations
$router->resource('articles', 'ArticleController');
$router->resource('products', 'ProductController');
$router->resource('orders', 'OrderController');
$router->resource('category', 'CategoryController');
$router->resource('users', 'UserController');
$router->resource('customers', 'CustomerController');
$router->resource('coupons', 'CouponController');
$router->resource('reviews', 'ReviewController');
$router->resource('contacts', 'ContactController');
$router->resource('discounts', 'DiscountController');
$router->resource('superadmin', 'AdminController');


// Additional custom routes can be added if necessary
$router->get('/', 'HomeController@index');
// $router->get('/{id}', 'HomeController@viewOrder');


// Dispatch the request
$requestedRoute = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Dispatch the route
$router->dispatch($requestedRoute);