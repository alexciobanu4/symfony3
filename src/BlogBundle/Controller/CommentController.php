<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use BlogBundle\Entity\Comment;
use BlogBundle\Form\CommentType;


class CommentController extends Controller
{
	private $session;
	
	public function __construct() {
		$this->session=new Session();
	}

	public function indexAction(){
		$em = $this->getDoctrine()->getManager();
		$comment_repo=$em->getRepository("BlogBundle:Comment");
		$comments=$comment_repo->findAllOrderBy("id");
		
		return $this->render("BlogBundle:Comment:index.html.twig",array(
			"comments" => $comments
		));
	}
	
	public function deleteAction($id){
		$em = $this->getDoctrine()->getManager();
		$comment_repo=$em->getRepository("BlogBundle:Comment");
		$comment=$comment_repo->find($id);

		$em->remove($comment);
		$em->flush();

		$status = "El comentario se ha eliminado";
		$this->session->getFlashBag()->add("status", $status);
		
		return $this->redirectToRoute("blog_index_comment", array('status' => $status));
	}

	public function verifyAction($id){
		$em = $this->getDoctrine()->getManager();
		$comment_repo=$em->getRepository("BlogBundle:Comment");
		$comment=$comment_repo->find($id);
		$comment->setActive(1);
		$em->persist($comment);
		$em->flush();

		$status = "El comentario ha sido aprobado";
		$this->session->getFlashBag()->add("status", $status);
		
		return $this->redirectToRoute("blog_index_comment", array('status' => $status));
	}
	
}
