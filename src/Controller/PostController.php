<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post")
     * @param PostRepository $repository
     * @return Response
     */
    public function index(PostRepository $repository)
    {
        $posts = $repository->findAll();
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/post/create", name="post.create")
     * @param  Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        // cria um novo post com titulo
        $post = new Post();
        $post->setTitle('Post Title');

        // entity manager
        $em = $this->getDoctrine()->getManager();
        $em->persist($post); // salva o Objeto Post na tabela post
        $em->flush();

        // return a response
        return new Response('O seu post foi criado.');
    }
}
