<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 04/03/19
 * Time: 13:33
 */

namespace Application\Controller;


use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Zend\Diactoros\Response\HtmlResponse;


/**
 * Class HomeController
 * @package Application\Controller
 */
class HomeController
{
    /**
     * @return HtmlResponse
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public  function index()
    {

        $loader = new FilesystemLoader("src/public");
        $twig = new Environment($loader, [
            'cache'=>false

        ]);

        $response = new HtmlResponse( $twig->render('home.twig'));

        return $response;
    }


}