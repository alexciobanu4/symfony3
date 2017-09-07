<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use BlogBundle\Entity\User;
use BlogBundle\Form\UserType;


class UserController extends Controller
{
	private $session;
	
	public function __construct() {
		$this->session=new Session();
	}

	public function indexAction(){
		$em = $this->getDoctrine()->getEntityManager();
		$user_repo=$em->getRepository("BlogBundle:User");
		$users=$user_repo->findAll();
		
		return $this->render("BlogBundle:User:index.html.twig",array(
			"users" => $users
		));
	}

	public function loginAction(Request $request){
		$authenticationUtils = $this->get("security.authentication_utils");
		$error = $authenticationUtils->getLastAuthenticationError();
		$lastUsername = $authenticationUtils->getLastUsername();

		return $this->render("BlogBundle:User:login.html.twig", array(
			"error" => $error,
			"last_username" => $lastUsername
		)); 
	}

	public function addAction(Request $request){
		$user = new User();
		$form = $this->createForm(UserType::class,$user);
		
		$form->handleRequest($request);

		if($form->isSubmitted()){
			if($form->isValid()){
				$em=$this->getDoctrine()->getEntityManager();
				$user_repo=$em->getRepository("BlogBundle:User");
				$user = $user_repo->findOneBy(array("email"=>$form->get("email")->getData()));
				
				if(count($user)==0){
					$user = new User();
					$user->setName($form->get("name")->getData());
					$user->setSurname($form->get("surname")->getData());
					$user->setEmail($form->get("email")->getData());

					$factory = $this->get("security.encoder_factory");
					$encoder = $factory->getEncoder($user);
					$password = $encoder->encodePassword($form->get("password")->getData(), $user->getSalt());

					$user->setPassword($password);
					$user->setRoles($form->get("roles")->getData());
					$user->setBirthday($form->get("birthday")->getData());
					$user->setImagen(null);

					$em = $this->getDoctrine()->getEntityManager();
					$em->persist($user);
					$flush = $em->flush();
					if($flush==null){
						$status = "El usuario se ha creado correctamente";
					}else{
						$status = "No te has registrado correctamente";
					}
				}else{
					$status = "El usuario ya existe!!!";
				}
			}else{
				$status = "Comprueba los errores en los campos";
			}

			$this->session->getFlashBag()->add("status",$status);
		}
		return $this->render("BlogBundle:User:add.html.twig", array(
			"form" => $form->createView(),
			"status" => $status
		)); 
	}

	public function editAction(Request $request, $id){
		$em=$this->getDoctrine()->getManager();
		$user_repo=$em->getRepository("BlogBundle:User");
		$user=$user_repo->find($id);

		$form = $this->createForm(UserType::class,$user);
		$form->handleRequest($request);

		if($form->isSubmitted()){
			if($form->isValid()){
				$user->setName($form->get("name")->getData());
				$user->setSurname($form->get("surname")->getData());
				$user->setEmail($form->get("email")->getData());

				$password = $user->getPassword();
				
				if(!empty($password) && $password!=null){
					$factory = $this->get("security.encoder_factory");
					$encoder = $factory->getEncoder($user);
					$password = $encoder->encodePassword($form->get("password")->getData(), $user->getSalt());
					$user->setPassword($password);
				}else{
					$user->setPassword($password);
				}

				$user->setRoles($form->get("roles")->getData());
				$user->setBirthday($form->get("birthday")->getData());
				$user->setImagen(null);

				$em->persist($user);
				$flush = $em->flush();

				if($flush==null) {
					$status = "El usuario se ha modificado correctamente";
				} else {
					$status = "Error al modificar usuario";
				}
			} else {
				$status = "Error al modificar usuario";
			}

			$this->session->getFlashBag()->add("status",$status);
			//return $this->redirectToRoute("blog_index_user");
		}
		return $this->render("BlogBundle:User:edit.html.twig", array(
			"form" => $form->createView(),
			"status" => $status,
			"user" => $user
		)); 
	}

	public function deleteAction($id){
		$em = $this->getDoctrine()->getManager();
		$user_repo=$em->getRepository("BlogBundle:User");
		$user=$user_repo->find($id);
		
		if(is_object($user)){
			$em->remove($user);
			$em->flush();
		}
		
		return $this->redirectToRoute("blog_index_user");
	}
}
