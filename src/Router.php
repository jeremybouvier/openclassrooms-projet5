<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 22/02/19
 * Time: 21:24
 */

namespace app;

use function Http\Response\send;
use Zend\Diactoros\Response\RedirectResponse;

class Router
{


    public function route($index = array())
    {


           ob_start();

        if ($index['page'] == 'home'){
            require 'view/home.php';



        }
        elseif ($index['page'] == 'listpost'){
            require 'view/listpost.php';
        }
        elseif ($index['page'] == 'post'){

            require 'view/post.php';
        }
        else
        {
            $response = new RedirectResponse('../index/home');
            send($response);
        }
        $body = ob_get_clean();

        $response = require 'view/templates/default.php';

        return $response;


    }




}
