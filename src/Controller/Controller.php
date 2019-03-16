<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 15/03/19
 * Time: 13:23
 */

namespace Application\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class Controller
{

    /**Initialisation de l'environement de Twig
     * @param $page
     * @param $data
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function templates($page, $data)
    {

        $loader = new FilesystemLoader('src/public');
        $twig = new Environment($loader, [
           'cache' => false
           ]);

        $htmlContent =$twig->render($page, $data);
        return $htmlContent;
    }

}