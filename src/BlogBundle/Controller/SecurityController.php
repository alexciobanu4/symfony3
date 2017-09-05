<?php
namespace BlogBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller {

    public function deniedAction() {

        return $this->render('BlogBundle:Security:denied.html.twig');
    }

}