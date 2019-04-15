<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 15/04/19
 * Time: 23:31
 */

namespace Application\Controller;


use Framework\Controller;

class LoginController extends Controller
{

    public function checkPassword()
    {
        $data=[];
        return $this->render('login.twig', $data);
    }

}