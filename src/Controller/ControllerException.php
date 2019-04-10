<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 06/04/19
 * Time: 22:48
 */

namespace Application\Controller;


/**
 * Class ControllerException
 * @package Application\Controller
 */
class ControllerException extends \Exception
{
    /**renvoi le message correspondant au code de l'erreur
     * @return string
     */
    public function getUserMessage()
    {
        switch ($this->getCode())
        {
            case '0':
                return ;
                break;
            case '1':
                return ;
                break;
        }
    }
}