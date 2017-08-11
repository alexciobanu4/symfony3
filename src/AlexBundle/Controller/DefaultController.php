<?php

namespace AlexBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
    	$productos = array(
    		array("producto"=>"Consola","precio"=>100),
    		array("producto"=>"Móvil","precio"=>340),
    		array("producto"=>"TV","precio"=>500),
    		array("producto"=>"Bicicleta","precio"=>130)
    	);

    	$fruta = array("manzana"=>"golden","pera"=>"grande");

        return $this->render('alex/index.html.twig', array(
        	'texto' => "Twig template",
        	'productos' => $productos,
        	'fruta' => $fruta
        ));
    }

    public function logoAction(Request $request)
    {
        return $this->render('alex/logo.html.twig', array(
        	'titulo' => "Logo page"
        ));
    }
}
