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

    /**
     * @var
     */
    private $response;

    /**
     * @var
     */
     private $message =[
         ['text' => ''] ,
         ['text' => 'Votre message a bien été envoyé'],
         ['text' => "Une erreur s'est produite merci de recommencer"]];

    /**Gestion de la page contact et de l'envoi de l'email
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index($idMessage)
    {
        if ($this->request->getRequest()->getMethod() == "POST" AND $this->tokenVerify()) {
            $mail = new Mail();
            $this->displayError = $mail->hydrate($this->request->getPost());
            $this->formControl($mail, $idMessage);
        }
        else{
            $this->response = $this->render('contact.twig', ['message' => $this->message[$idMessage],
                'displayError' => $this->displayError, 'session' => $_SESSION]);
        }
        return $this->ticketVerify($this->response);
    }

    /**Permet l'envoi de l'email s'il n'y a pas d'erreur sur le formulaire
     * @param $mail
     * @param $idMessage
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    private function formControl($mail, $idMessage)
    {
        if ($this->checkError($this->displayError) == false){
            $mail->setMessage(wordwrap(
                'Vous avez recu un message de : ' . "\r\n" .
                $mail->getName() . "\r\n" .
                'son email est : ' . "\r\n" .
                $mail->getEmail() . "\r\n" .
                'voici son message : ' . "\r\n" .
                $mail->getMessage(), 70, "\r\n"));
            $idMessage = $this->sendMail($mail);
            $this->response = $this->redirect('contactPage', 301,['message' => $idMessage]);
        }
        else{
            $this->response = $this->render('contact.twig', [
                'email' => $mail,
                'message' => $this->message[$idMessage],
                'displayError' => $this->displayError,
                'session' => $_SESSION]);
        }
    }

    /**Permet d'envoyer un email
     * @param $mail
     * @return string
     */
    public function sendMail($mail)
    {
        if (mail('jeremybouvier2b@gmail.com', $mail->getSubject(), $mail->getMessage())){
            return '1';
        }
        else{
            return '2';
        }

    }
}