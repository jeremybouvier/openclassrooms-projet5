<?php

namespace Application\Controller;


use Framework\Controller;
use Zend\Diactoros\Response\RedirectResponse;

/**
 * Permet de rediriger le visiteur sur le home page
 * @package Application\Controller
 */

class WelcomeController extends Controller
{
    /**
     * @return RedirectResponse
     */
    public function index()
    {
        return $this->redirect('homePage',301);
    }
}