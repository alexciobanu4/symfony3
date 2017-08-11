<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class BlogController extends Controller
{
   
    public function indexAction()
    {
        $posts = $this->getDoctrine()
                ->getRepository('AppBundle:Blog')
                ->findAll();
        
        return $this->render('blog/index.html.twig', array(
            'posts' => $posts
        ));
    }
    
   
    public function createAction(Request $request)
    {
        $todo = new \AppBundle\Entity\Blog();
        $atrributes = array('class' => 'form-control' , 'style' => 'margin-bottom:15px');
        $form = $this->createFormBuilder($todo)
                ->add('titulo', TextType::class, array('attr' => $atrributes))
                ->add('descripcion', TextareaType::class, array('attr' => $atrributes))
                ->add('image', FileType::class, array('attr' => $atrributes))
                ->add('due_date', DateTimeType::class, array('attr' => array('style' => 'margin-bottom:15px')))
                ->add('save', SubmitType::class, array('label' => 'Create Post', 'attr' => array('class' => 'btn btn-primary')))
                ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $todo->setTitulo($form['titulo']->getData());
            $todo->setDescripcion($form['descripcion']->getData());
            $todo->setDueDate($form['due_date']->getData());
            $todo->setCreateDate(new \DateTime('now'));

            $file = $todo->getImage();
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            // Move the file to the directory where brochures are stored
            $file->move($this->getParameter('uploads_directory'), $fileName);
            $todo->setImage($fileName);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($todo);
            $em->flush();
            
            $this->addFlash('notice', 'Post Added');
            
            return $this->redirectToRoute('blog_list');
        }
        
        return $this->render('blog/create.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    
    public function editAction($id, Request $request)
    {
        $todo = $this->getDoctrine()
                ->getRepository('AppBundle:Blog')
                ->find($id);
        
        if (empty($todo)) {
            $this->addFlash('error', 'Post not found');
            
            return $this->redirectToRoute('blog_list');
        }
        
        $atrributes = array('class' => 'form-control' , 'style' => 'margin-bottom:15px');
        $form = $this->createFormBuilder($todo)
                ->add('titulo', TextType::class, array('attr' => $atrributes))
                ->add('descripcion', TextareaType::class, array('attr' => $atrributes))
                ->add('due_date', DateTimeType::class, array('attr' => array('style' => 'margin-bottom:15px')))
                ->add('save', SubmitType::class, array('label' => 'Update Post', 'attr' => array('class' => 'btn btn-primary')))
                ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $todo->setTitulo($form['titulo']->getData());
            $todo->setDescripcion($form['descripcion']->getData());
            $todo->setDueDate($form['due_date']->getData());
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($todo);
            $em->flush();
            
            $this->addFlash('notice', 'Post updated');
            
            return $this->redirectToRoute('blog_list');
        }
        
        return $this->render('blog/edit.html.twig', array(
            'form' => $form->createView(),
            'blog' => $todo
        ));
    }
    

    public function detailsAction($id)
    {
        $todo = $this->getDoctrine()
                ->getRepository('AppBundle:Blog')
                ->find($id);
        if (empty($todo)) {
            $this->addFlash('error', 'Post not found');
            
            return $this->redirectToRoute('blog_list');
        }
        
        return $this->render('blog/detail.html.twig', array(
            'blog' => $todo
        ));
    }

    public function deleteAction($id)
    {
        $todo = $this->getDoctrine()
                ->getRepository('AppBundle:Blog')
                ->find($id);
        
        if (empty($todo)) {
            $this->addFlash('error', 'Post not found');
            
            return $this->redirectToRoute('blog_list');
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($todo);
        $em->flush();
        
        $this->addFlash('notice', 'Post removed');
       
        return $this->redirectToRoute('blog_list');
    }
}
