<?php

namespace Application\Controller;


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
        return $this->route->redirect('/home',301);
    }
}