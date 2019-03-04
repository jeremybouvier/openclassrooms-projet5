<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 04/03/19
 * Time: 13:33
 */

namespace Application\Controller;


use Couchbase\ViewQuery;

class HomeController
{

    public  function index()
    {
        ob_start();
        require 'public/home.php';
        $body = ob_get_clean();
        require 'public/templates/default.php';
    }
}