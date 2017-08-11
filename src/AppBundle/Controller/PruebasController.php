<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PruebasController extends Controller
{
    
    public function indexAction(Request $request, $lang, $name, $number)
    {
        
        $baseUrl = $request->getBaseUrl(); //Obtiene la ruta de base
        //Crear una redirección
        //return $this->redirect($baseUrl . "/blog");
        
        //Recoje parametros por get
        $parametro = $request->get("texto");
        echo $parametro;

        return $this->render('AppBundle:Pruebas:index.html.twig', [
            'texto' => $name . " - " . $number . " - " . $lang . " - Ruta base: " .$baseUrl
        ]);
    }

}
?>