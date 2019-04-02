<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 04/03/19
 * Time: 13:42
 */

namespace Application\Controller;


use Framework\Router\Route;
use Zend\Diactoros\Response\RedirectResponse;

/**
 * Permet de rediriger le visiteur sur le home page
 * @package Application\Controller
 */

class WelcomeController
{
    /**
     * @return RedirectResponse
     */
    public function index()
    {
        $response = $this->route->redirect('/home',301);
        return $response;
    }
}