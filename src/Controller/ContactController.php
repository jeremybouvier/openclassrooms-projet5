<?php
/**
 * Created by PhpStorm.
 * User: jeremy
 * Date: 24/04/19
 * Time: 21:39
 */

namespace Application\Controller;


use Application\Model\Mail;
use Framework\Controller;

/**
 * Class ContactController
 * @package Application\Controller
 */
class ContactController extends Controller
{
    /**
     * @var
     */
    private $displayError;

    /**Gestion de la page contact et de l'envoi de l'email
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $message ='';
        if ($this->request->getRequest()->getMethod() == "POST") {
            $mail = new Mail();
            $this->displayError = $mail->hydrate($_POST);
            if ($this->checkError($this->displayError) == false){
                $mail->setMessage(wordwrap(
                    'Vous avez recu un message de : ' . "\r\n" .
                    $mail->getName() . "\r\n" .
                    'son email est : ' . "\r\n" .
                    $mail->getEmail() . "\r\n" .
                    'voici son message : ' . "\r\n" .
                    $mail->getMessage(), 70, "\r\n"));
                if (mail(
                    'jeremybouvier2b@gmail.com',
                    $mail->getSubject(),
                    $mail->getMessage()
                )){
                    $message = ['text' => 'Votre message a bien été envoyé'];
                }
                else{
                    $message = ['text' => "Une erreur s'est produite merci de recommencer"];
                }
                return $this->redirect('contactPage', 302);
            }
        }
        return $this->render('contact.twig', ['message' => $message, 'displayError' => $this->displayError]);
    }
}