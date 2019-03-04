<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 04/03/19
 * Time: 13:42
 */

namespace Application\Controller;


class WelcomeController
{

    public function index()
    {
        echo "Welcome on my personnal Blog <br />click on this link to access at the home page <a href='../index/home'>>>Home page </a>";
    }
}