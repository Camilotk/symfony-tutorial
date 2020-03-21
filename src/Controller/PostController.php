<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
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

        // cria um novo formulário usando PostType de modelo que após preenchido
        // passa as informações para o objeto $post
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            // entity manager
            $em = $this->getDoctrine()->getManager();
            $em->persist($post); // salva o Objeto Post na tabela post
            $em->flush();

            $this->addFlash('success', 'O post ' . $post->getTitle() . ' foi criado.' );

            return $this->redirect($this->generateUrl('post'));
        }

        // return a response
        return $this->render('post/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/post/show/{id}", name="post.show")
     * @param  Request $request
     * @return Response
     */
    public function show(PostRepository $repository, $id)
    {
        $post = $repository->find($id);
        return $this->render('post/show.html.twig', [ 'post' => $post]);
    }

    /**
     * @Route("/post/delete/{id}", name="post.delete")
     * @param  Request $request
     * @return Response
     */
    public function remove(PostRepository $repository, $id)
    {
        $post = $repository->find($id);

        // entity manager
        $em = $this->getDoctrine()->getManager();
        $em->remove($post); // remove
        $em->flush();

        $this->addFlash('success', 'O Post foi deletado');

        return $this->redirect($this->generateUrl('post'));
    }
}
