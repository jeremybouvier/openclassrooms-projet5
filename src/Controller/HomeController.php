<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 04/03/19
 * Time: 13:33
 */

namespace Application\Controller;


use Zend\Diactoros\Response\HtmlResponse;


/**
 * Class HomeController
 * @package Application\Controller
 */
class HomeController
{
    /**renvoi l'affichage de la home page
     * @return HtmlResponse
     */
    public  function index()
    {
        ob_start();
        require 'public/home.php';
        $body = ob_get_clean();

        ob_start();
        require 'public/templates/default.php';
        $htmlContent = ob_get_clean();

        $response = new HtmlResponse($htmlContent);
        return $response;
    }
}