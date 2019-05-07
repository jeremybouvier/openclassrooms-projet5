<?php

namespace Application\Controller;


use Framework\Controller;
use Zend\Diactoros\Response\HtmlResponse;

/**
 * Class HomeController
 * @package Application\Controller
 */
class HomeController extends Controller
{
    /**Renvoie sur la home page
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public  function index()
    {
        return $this->ticketVerify($this->render('home.twig', []));
    }
}