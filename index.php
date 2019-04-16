<?php
session_start();

require 'vendor/autoload.php';


use \Framework\Router\Router;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

$router = new Router();
$router->setRoute('welcome','/', "Welcome#index");
$router->setRoute('homePage','home', "Home#index");
$router->setRoute('postsPage','listPost', "Post#getAllPost");
$router->setRoute('onePostPage', 'post/:id', "Post#getSinglePost");
$router->setRoute('editPostPage', 'editPost/:id', "Post#editPost");
$router->setRoute('editUserPage', 'editUser/:id', "User#editUser");
$router->setRoute('loginPage','login', "Login#checkPassword");
$router->setRoute('administrationPage','admin', "Admin#dashboard");
$router->setRoute('deleteComment','deleteComment/:id/:idComment', "Comment#deleteComment");
$router->setRoute('test','test', "Test#test");
$response = $router->run($router);
$emitter = new SapiEmitter();
$emitter->emit($response);

?>