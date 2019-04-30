<?php

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

    private $message;

    /**Gestion de la page contact et de l'envoi de l'email
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $this->message = '';
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
                $this->message = $this->sendMail($mail);
            }
        }
        return $this->render('contact.twig', ['message' => $this->message, 'displayError' => $this->displayError]);
    }

    public function sendMail($mail)
    {
        if (mail('jeremybouvier2b@gmail.com', $mail->getSubject(), $mail->getMessage())){
            return ['text' => 'Votre message a bien été envoyé'];
        }
        else{
            return ['text' => "Une erreur s'est produite merci de recommencer"];
        }
    }
}