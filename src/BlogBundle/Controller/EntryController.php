<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use BlogBundle\Entity\Entry;
use BlogBundle\Form\EntryType;

class EntryController extends Controller
{
	private $session;
	
	public function __construct() {
		$this->session=new Session();
	}
	
	public function indexAction(Request $request, $page){		
		$em = $this->getDoctrine()->getEntityManager();
		$entry_repo=$em->getRepository("BlogBundle:Entry");
		$category_repo=$em->getRepository("BlogBundle:Category");
		
		$categories=$category_repo->findAll();
		
		$pageSize = 5;
		$entries=$entry_repo->getPaginateEntries($pageSize,$page);
		//$entries=$entry_repo->nativeSqlQuery();
		
		$totalItems = count($entries);
		$pagesCount = ceil($totalItems/$pageSize);

		$category_list = "";
		foreach($categories as $cat_list){
			$category_list .= "." . $cat_list->getSlug() . ", ";
		}
		
		return $this->render("BlogBundle:Entry:index.html.twig",array(
			"entries" => $entries,
			"categories" => $categories,
			"category_list" => substr($category_list, 0, -2),
			"totalItems" => $totalItems,
			"pagesCount" => $pagesCount,
			"page" => $page,
			"page_m" => $page
		));
	}

	public function customAction(Request $request){		
		$em = $this->getDoctrine()->getEntityManager();
		$entry_repo=$em->getRepository("BlogBundle:Entry");

		$entries=$entry_repo->nativeSqlQuery();

		return $this->render("BlogBundle:Entry:custom.html.twig",array(
			"entries" => $entries
		));
	}


	public function addAction(Request $request){
		$entry = new Entry();
		$form = $this->createForm(EntryType::class,$entry);
		
		$form->handleRequest($request);
		
		if($form->isSubmitted()){
			if($form->isValid()){
				
				$em = $this->getDoctrine()->getEntityManager();
				$entry_repo=$em->getRepository("BlogBundle:Entry");
				$category_repo=$em->getRepository("BlogBundle:Category");
				$page_repo = $em->getRepository("BlogBundle:Page");
				
				$entry = new Entry();
				$entry->setTitle($form->get("title")->getData());
				$entry->setContent($form->get("content")->getData());
				$entry->setStatus($form->get("status")->getData());
				$entry->setActive($form->get("active")->getData());
				
				$fecha = date("Y-m-d");
				$entry->setDate(new \DateTime($fecha));
				// upload file
				$file=$form["image"]->getData();
				
				if(!empty($file) && $file!=null){
					$ext=$file->guessExtension();
					$file_name=time().".".$ext;
					$file->move("assets/uploads",$file_name);

					$entry->setImage($file_name);
				}else{
					$entry->setImage(null);
				}
				
				$category = $category_repo->find($form->get("category")->getData());
				$entry->setCategory($category);
				
				$user=$this->getUser();
				$entry->setUser($user);

				$page = $page_repo->find($form->get("page")->getData());
				$entry->setPage($page);
				
				$em->persist($entry);
				$flush=$em->flush();
				
				$entry_repo->saveEntryTags(
						$form->get("tags")->getData(),
						$form->get("title")->getData(),
						$category,
						$user
						);
				
				if($flush==null){
					$status = "La ENTRADA se ha creado correctamente !!";
				}else{
					$status ="Error al añadir la entrada!!";
				}
				
			}else{
				$status = "La entrada no se ha creado, porque el formulario no es valido !!";
			}
			
			$this->session->getFlashBag()->add("status", $status);
			return $this->redirectToRoute("blog_homepage");
		}
		
		
		return $this->render("BlogBundle:Entry:add.html.twig",array(
			"form" => $form->createView()
		));
	}
	
	public function deleteAction($id){
		$em = $this->getDoctrine()->getEntityManager();
		$entry_repo=$em->getRepository("BlogBundle:Entry");
		$entry_tag_repo=$em->getRepository("BlogBundle:EntryTag");
		
		$entry=$entry_repo->find($id);
		
		$entry_tags=$entry_tag_repo->findBy(array("entry"=>$entry));
		
		foreach($entry_tags as $et){
			if(is_object($et)){
				$em->remove($et);
				$em->flush();
			}
		}

		$entry_image=$entry->getImage();
		$webPath = __DIR__.'/../../../web/dist/uploads/';
		$imagePath = $webPath.$entry_image;
		
		if($imagePath!=null) {
			unlink($imagePath);
		}

		if(is_object($entry)){
			$em->remove($entry);
			$em->flush();
		}
		
		return $this->redirectToRoute("blog_homepage");
	}
	
	public function editAction(Request $request, $id){

		$em = $this->getDoctrine()->getEntityManager();
		$entry_repo = $em->getRepository("BlogBundle:Entry");
		$category_repo = $em->getRepository("BlogBundle:Category");
		$user_repo = $em->getRepository("BlogBundle:User");
		$page_repo = $em->getRepository("BlogBundle:Page");
		
		$entry=$entry_repo->find($id);
		$entry_image=$entry->getImage();
		
		$tags="";
		foreach($entry->getEntryTag() as $entryTag){
			$tags.=$entryTag->getTag()->getName().",";
		}
		
		$form = $this->createForm(EntryType::class, $entry);
		
		$form->handleRequest($request);
		
		if($form->isSubmitted()){
			if($form->isValid()){
				
				$entry->setTitle($form->get("title")->getData());
				$entry->setContent($form->get("content")->getData());
				$entry->setStatus($form->get("status")->getData());
				$entry->setActive($form->get("active")->getData());

				// upload file
				$file=$form["image"]->getData();
				
				if(!empty($file) && $file!=null){
					$ext=$file->guessExtension();
					$file_name=time().".".$ext;
					$file->move("assets/uploads",$file_name);

					$entry->setImage($file_name);
				}else{
					$entry->setImage($entry_image);
				}

				$category = $category_repo->find($form->get("category")->getData());
				$entry->setCategory($category);
				
				//$user=$this->getUser();
				$user = $user_repo->find($form->get("user")->getData());
				$entry->setUser($user);

				$page = $page_repo->find($form->get("page")->getData());
				$entry->setPage($page);
				
				$em->persist($entry);
				$flush=$em->flush();
				
				
				$entry_tag_repo=$em->getRepository("BlogBundle:EntryTag");
				$entry_tags=$entry_tag_repo->findBy(array("entry"=>$entry));

				foreach($entry_tags as $et){
					if(is_object($et)){
						$em->remove($et);
						$em->flush();
					}
				}
				
				$entry_repo->saveEntryTags(
					$form->get("tags")->getData(),
					$form->get("title")->getData(),
					$category,
					$user
				);
				
				if($flush==null){
					$status = "La entrada se ha editado correctamente";
				}else{
					$status = "La entrada se ha editado mal";
				}
				
			}else{
				$status = "El formulario no es valido";
			}
			
			$this->session->getFlashBag()->add("status", $status);
			//return $this->redirectToRoute("blog_homepage");
		}
		
		return $this->render("BlogBundle:Entry:edit.html.twig",array(
			"form" => $form->createView(),
			"entry" => $entry,
			"tags" => $tags
		));
	}

	public function viewAction(Request $request, $id){

		$em = $this->getDoctrine()->getEntityManager();
		$entry_repo = $em->getRepository("BlogBundle:Entry");

		$entry=$entry_repo->viewEntry($id);

		$tags="";
		foreach($entry->getEntryTag() as $entryTag){
			$tags.=$entryTag->getTag()->getName().",";
		}

		return $this->render("BlogBundle:Entry:view.html.twig",array(
			"entry" => $entry,
			"tags" => $tags
		));
	}
	
}
