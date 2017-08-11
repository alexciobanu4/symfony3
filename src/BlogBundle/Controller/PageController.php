<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use BlogBundle\Entity\Page;
use BlogBundle\Form\PageType;


class PageController extends Controller
{
	private $session;
	
	public function __construct() {
		$this->session=new Session();
	}

	public function indexAction(){
		$em = $this->getDoctrine()->getEntityManager();
		$page_repo=$em->getRepository("BlogBundle:Page");
		$pages=$page_repo->findAll();
		
		return $this->render("BlogBundle:Page:index.html.twig",array(
			"pages" => $pages
		));
	}
	
	public function addAction(Request $request){
		$page = new Page();
		$form = $this->createForm(PageType::class,$page);
		
		$form->handleRequest($request);
		
		if($form->isSubmitted()){
			if($form->isValid()){
				
				$em = $this->getDoctrine()->getEntityManager();
				
				$page = new Page();
				$page->setTitle($form->get("title")->getData());
				$page->setDescription($form->get("description")->getData());
				
				$em->persist($page);
				$flush = $em->flush();
				
				if($flush==null){
					$status = "La página se ha creado correctamente !!";
				}else{
					$status ="Error al añadir la página!!";
				}
				
			}else{
				$status = "La página no se ha creado, porque el formulario no es valido !!";
			}
			
			$this->session->getFlashBag()->add("status", $status);
			return $this->redirectToRoute("blog_index_page");
		}
		
		return $this->render("BlogBundle:Page:add.html.twig",array(
			"form" => $form->createView()
		));
	}
	
	// public function deleteAction($id){
	// 	$em = $this->getDoctrine()->getEntityManager();
	// 	$category_repo=$em->getRepository("BlogBundle:Category");
	// 	$category=$category_repo->find($id);
		
	// 	if(count($category->getEntries())==0){
	// 		$em->remove($category);
	// 		$em->flush();
	// 	}
		
	// 	return $this->redirectToRoute("blog_index_category");
	// }
	
	public function editAction(Request $request, $id){
		$em = $this->getDoctrine()->getEntityManager();
		$page_repo=$em->getRepository("BlogBundle:Page");
		$page=$page_repo->find($id);
		
		$form = $this->createForm(PageType::class,$page);
		
		$form->handleRequest($request);
		
		if($form->isSubmitted()){
			if($form->isValid()){
				
				$page->setTitle($form->get("title")->getData());
				$page->setDescription($form->get("description")->getData());
				
				$em->persist($page);
				$flush = $em->flush();
				
				if($flush==null){
					$status = "La página se ha editado correctamente !!";
				}else{
					$status ="Error al editar la página!!";
				}
				
			}else{
				$status = "La página no se ha editado, porque el formulario no es valido !!";
			}
			
			$this->session->getFlashBag()->add("status", $status);
			return $this->redirectToRoute("blog_index_page");
		}
		
		return $this->render("BlogBundle:Page:edit.html.twig",array(
			"form" => $form->createView()
		));
	}
	
}
