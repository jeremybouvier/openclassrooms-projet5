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

    public function templates($page, $class,$className)
    {

        $loader = new FilesystemLoader('src/public');
        $twig = new Environment($loader, [
           'cache' => false
           ]);

        $htmlContent =$twig->render($page,[
           $className=>$class
        ]);
        return $htmlContent;
    }

}