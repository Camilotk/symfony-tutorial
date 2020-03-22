<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     */
    public function index(PostRepository $repository)
    {
        $posts = $repository->findAll();
        return $this->render('home/index.html.twig', compact('posts'));
    }

    /**
     * @Route("/custom/{name?}", name="custom")
     */
    public function custom(Request $request)
    {
        $name = $request->get('name');
        return $this->render('home/custom.html.twig', compact('name'));
    }
}
