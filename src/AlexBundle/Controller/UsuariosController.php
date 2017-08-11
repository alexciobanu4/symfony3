<?php

namespace AlexBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AlexBundle\Entity\Usuarios;
use AlexBundle\Form\UsuariosType;

class UsuariosController extends Controller
{
    //Leemos el registro
    public function listAction() {
        $usuarios = $this->getDoctrine()
        ->getRepository('AlexBundle:Usuarios')
        ->findAll();

        return $this->render('usuarios/list.html.twig', array(
            'usuarios' => $usuarios
        ));

    }

    //Insertamos registros a la bbdd
    public function createAction() {
    	$usuario = new Usuarios();
    	$usuario->setName("Alex");
    	$usuario->setSurname("Ciobanu");
    	$usuario->setEmail("aciobanu@advancegroup.es");
    	$usuario->setDescription("Mi usuario");
    	$usuario->setPassword("Advance2017");

    	$em = $this->getDoctrine()->getManager();
    	$em->persist($usuario);
    	$flush=$em->flush();

    	if($flush != null) {
    		return $this->render('usuarios/create.html.twig', array(
                'confirm' => "El usuario no se ha creado"
            ));
    	} else {
    		return $this->render('usuarios/create.html.twig', array(
                'confirm' => "El usuario se ha creado correctamente"
            ));
    	}
    }

    //Actualizamos el registro
    public function updateAction($id, $name, $surname) {
        $em = $this->getDoctrine()->getManager();
        $usuarios_repo = $em->getRepository("AlexBundle:Usuarios");

        $usuarios = $usuarios_repo->find($id);
        $usuarios->setName($name);
        $usuarios->setSurname($surname);

        $em->persist($usuarios);
        $flush = $em->flush();

        if($flush != null) {
            return $this->render('usuarios/update.html.twig', array(
                'confirm' => "El usuario no se ha actualizado"
            ));
        } else {
            return $this->render('usuarios/update.html.twig', array(
                'confirm' => "El usuario se ha actualizado correctamente"
            ));
        }

    }

    //Borramos el registro
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $usuarios_repo = $em->getRepository("AlexBundle:Usuarios");
        $usuarios = $usuarios_repo->find($id);
        $em->remove($usuarios);
        $flush = $em->flush();

        if($flush != null) {
            return $this->render('usuarios/delete.html.twig', array(
                'confirm' => "El usuario no se ha borrado"
            ));
        } else {
            return $this->render('usuarios/delete.html.twig', array(
                'confirm' => "El usuario se ha borrado correctamente"
            ));
        }

    }

    //Crear una query personalizada y mostrar resultados
    public function queryAction($param) {
        $em = $this->getDoctrine()->getManager();
        $db = $em->getConnection();
        $query = "SELECT * FROM usuarios WHERE name = '$param'";
        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);

        $usuarios = $stmt->fetchAll();

        foreach($usuarios as $usuario) {
            echo $usuario["name"];
        }

        die();
    }

    //Crear una query con DQL
    public function dqlAction() {
        $em = $this->getDoctrine()->getManager();
        
        $query = $em->createQuery("
            SELECT u FROM AlexBundle:Usuarios u
        ");

        $usuarios = $query->getResult();

        foreach($usuarios as $usuario) {
            echo $usuario->getName();
        }

        die();
    }

    //Crear formulario con los campos de una entidad
    public function formAction(Request $request) {
        $cursos = new Usuarios();
        $form = $this->createForm(UsuariosType::class, $cursos);

        $form->handleRequest($request);

        if($form->isValid()) {
            $status = "Formulario valido";
            $data = array(
                    "nombre" => $form->get("nombre")->getData(),
                    "apellidos" => $form->get("apellidos")->getData()
                );
        } else {
            $status = null;
            $data = null;
        }

        return $this->render('usuarios/form.html.twig', array(
            'form' => $form->createView(),
            'status' => $status,
            'data' => $data
        ));

    }


}
