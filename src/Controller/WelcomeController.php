<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 04/03/19
 * Time: 13:42
 */

namespace Application\Controller;


use Zend\Diactoros\Response\RedirectResponse;

/**
 * Permet de rediriger le visiteur sur le home page
 * @package Application\Controller
 */

class WelcomeController
{
    public function index()
    {
        $response = new RedirectResponse('/home',301);
        return $response;
    }
}