<?php


namespace App\Controller;


use App\Entity\BlogPost;
use App\Form\BlogPostFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(): Response
    {
        return $this->render('home.html.twig');
    }

    /**
     * @Route("/post/new", name="post_new")
     */
    public function new(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(BlogPostFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $blogPost = new BlogPost();
            $blogPost->setTitle($data['title']);
            $blogPost->setPostContent($data['postContent']);

            $em->persist($blogPost);
            $em->flush();

            return $this->redirectToRoute('app_homepage');

        }

        return $this->render('new.html.twig', [
            'blogForm' => $form->createView()
        ]);
    }
}
