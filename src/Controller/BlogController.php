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
    public function homepage(EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository(BlogPost::class);
        $blogPosts = $repository->findAll();

        return $this->render('home.html.twig', [
            'blogPosts' => $blogPosts,
        ]);
    }

    /**
     * @Route("/posts", name="app_list_posts")
     */
    public function listPosts(EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository(BlogPost::class);
        $blogPosts = $repository->findAll();

        return $this->render('list.html.twig', [
            'blogPosts' => $blogPosts,
        ]);
    }

    /**
     * @Route("/post/new", name="app_post_new")
     */
    public function new(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(BlogPostFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var BlogPost $blogPost */
            $blogPost = $form->getData();
            $blogPost->setPublishedAt(new \DateTime());

            $em->persist($blogPost);
            $em->flush();

            return $this->redirectToRoute('app_homepage');

        }

        return $this->render('new.html.twig', [
            'blogForm' => $form->createView()
        ]);
    }
}
