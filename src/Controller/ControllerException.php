<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 06/04/19
 * Time: 22:48
 */

namespace Application\Controller;


class ControllerException extends \Exception
{

    public function getUserMessage()
    {
        switch ($this->getCode())
        {
            case '0':
                return 'Merci de remplir ce champ';
                break;
            case '1':
                return 'Maximum 20 charactère ';
                break;
        }
    }
}