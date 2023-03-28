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

class PostController extends AbstractController
{
    #[Route('/setArticle1', name: 'set_article1')]
    public function setArticleCat1(
        EntityManagerInterface $manager,
        PostCategoryRepository $catRepo,
    )
    {
        $catData = $catRepo->findOneBy(['title' => 'Catégorie 1']);

        // return new Response("Type: " . gettype($catData->getTitle()));
        // return new Response ($catData->getTitle());
        // return new Response ($response);
        // return new Response (print_r($catData));

        $post = new Post();
        $post->setTitre('titre');
        $post->setMessage('Coucou je suis un nouveau message de catégorie 1 !');
        $post->setDate(new DateTime());
        $post->setCategorie($catData);

        $manager->persist($post);
        $manager->flush();

        return $this->redirectToRoute("twig_articles");
    }

    #[Route('/setArticle2', name: 'set_article2')]
    public function setArticleCat2(
        EntityManagerInterface $manager,
        PostCategoryRepository $catRepo,
    )
    {
        $catData = $catRepo->findOneBy(['title' => 'Catégorie 2']);
        $response = json_encode($catData, JSON_PRETTY_PRINT);

        //return new Response ($catData->getTitle());
        //return new Response ($response);
        //return new Response (print_r($catData));

        $post = new Post();
        $post->setTitre('titre');
        $post->setMessage('Coucou je suis un nouveau message de catégorie 2 !');
        $post->setDate(new DateTime());
        $post->setCategorie($catData);

        $manager->persist($post);
        $manager->flush();

        return $this->redirectToRoute("twig_articles");
    }

    #[Route('/delArticle1', name: 'del_article1')]
    public function delArticleCat1(
        EntityManagerInterface $manager,
        PostCategoryRepository $catRepo,
        PostRepository $postRepo,
    )
    {
        //$articles = $catRepo->findOneBy(['title' => 'Catégorie 1'])->getPosts();
        $article = $postRepo->findOneBy(['categorie' => 1], ['id' => 'DESC']);


        if ($article) {
            $manager->remove($article);
            $manager->flush();
        }

        return new JsonResponse ($article);
        return $this->redirectToRoute("twig_articles");
    }

    #[Route('/delArticle2', name: 'del_article2')]
    public function delArticleCat2(
            EntityManagerInterface $manager,
            PostCategoryRepository $catRepo,
            PostRepository $postRepo,
        )
        {
            //$articles = $catRepo->findOneBy(['title' => 'Catégorie 2'])->getPosts();
            $article = $postRepo->findOneBy(['categorie' => 8], ['id' => 'DESC']);
    
    
            if ($article) {
                $manager->remove($article);
                $manager->flush();
            }
    
            return new JsonResponse ($article);
            return $this->redirectToRoute("twig_articles");
        }

    #[Route('/setCategory', name: 'set_category')]
    public function setCat(EntityManagerInterface $manager)
    {
        $table = new PostCategory();
        $table->setTitle('Catégorie1');

        $manager->persist($table);
        $manager->flush();

        return $this->redirectToRoute("twig_articles");
    }

    #[Route('/setPost', name: 'set_post')]
    public function setPost(EntityManagerInterface $manager)
    {
        $table = new Post();
        $table->setTitre('Post 1');
        $table->setMessage('Lorem Ipsum');
        $table->setDate(new DateTime());

        $manager->persist($table);
        $manager->flush();

        return $this->redirectToRoute("twig_articles");
    }

    #[Route('/getID1', name: 'get_id1')]
    public function getID1(
        EntityManagerInterface $manager,
        PostRepository $postRepo,
        PostCategoryRepository $catRepo,
        )
    {
        $postCol = $postRepo->find(1);
        $catCol = $catRepo->find(1);

        return $this->render('results/get_id.html.twig', [
            'dataCategory' => $catCol,
            'dataPost' => $postCol,
        ]);
    }
    
    #[Route('/updateTitle', name: 'update_title')]
    public function updateTitle(
        EntityManagerInterface $manager,
        PostRepository $postRepo,
    )
    {
        $postData = $postRepo->find(1);
        
        $post = new Post();
        $post->setTitre($postData->getTitre());
        $post->setMessage($postData->getMessage());
        $post->setDate($postData->getDate());

        $manager->persist($post);
        $manager->flush();

        return $this->redirectToRoute("twig_articles");
    }

    #[Route('/getPost', name: 'get_post')]
    public function getPost(
        EntityManagerInterface $manager,
        PostRepository $postRepo,
    )
    {
        
        $posts = $postRepo->findAll();
                
        // return $this->render('articles/index.html.twig', [
        //     'articles' => $posts,
        // ]);   

        return new JsonResponse ($posts);
        
        // $query = $postRepo->createQueryBuilder('p')
        // ->orderBy('p.categorie', 'ASC')
        // ->getQuery();
                
        // $posts = $query->getResult();

        // $postsCategory1 = array_filter($posts, function ($post) {
        //     return $post->getCategorie() !== null && $post->getCategorie()->getTitle() === 'Catégorie 1';
        // });
        
        // $postsCategory2 = array_filter($posts, function ($post) {
        //     return $post->getCategorie() !== null && $post->getCategorie()->getTitle() === 'Catégorie 2';
        // });

        // return $this->render('results/all_posts.html.twig', [
        //     'postsCategory1' => $postsCategory1,
        //     'postsCategory2' => $postsCategory2,
        // ]);
        
    }
}
?>