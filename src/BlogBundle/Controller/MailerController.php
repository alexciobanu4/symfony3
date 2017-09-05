<?php
namespace BlogBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MailerController extends Controller {

	protected $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail($user)
    {

        $message = \Swift_Message::newInstance()
            ->setSubject('Nuevo comentario')
            ->setFrom('aciobanu@advancegroup.es')
            ->setTo('aciobanu@advancegroup.es')
            ->setBody($this->renderView('BlogBundle:Emails:email.html.twig', array(
                'user' => $user
            )
        ));

        $this->mailer->send($message);
    }

}