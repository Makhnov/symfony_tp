<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PostRepository;
use App\Repository\PostCategoryRepository;
use App\Entity\Post;
use App\Entity\PostCategory;

use DateTime;

class ArticlesController extends AbstractController
{
    #[Route('/articles', name: 'twig_articles')]
    public function index(        
        PostRepository $postRepo,
    )
    {
        $posts = $postRepo->findAll();
                
        return $this->render('articles/index.html.twig', [
            'articles' => $posts,
        ]);   

        //return new JsonResponse ($posts);
    }
}
?>