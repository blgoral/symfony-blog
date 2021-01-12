<?php


namespace App\Controller;


use App\Form\BlogPostFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function homepage(): Response
    {
        return $this->render('home.html.twig');
    }

    /**
     * @Route("/post/new")
     */
    public function new()
    {
        $form = $this->createForm(BlogPostFormType::class);

        return $this->render('new.html.twig', [
            'blogForm' => $form->createView()
        ]);
    }
}
