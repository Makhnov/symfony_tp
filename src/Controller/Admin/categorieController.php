<?php

namespace App\Controller\Admin;

use App\Entity\PostCategory;
use App\Form\PostCategory2Type;
use App\Repository\PostCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/categorie')]
class categorieController extends AbstractController
{
    #[Route('/', name: 'app_admin_categorie_index', methods: ['GET'])]
    public function index(PostCategoryRepository $postCategoryRepository): Response
    {
        return $this->render('admin/categorie/index.html.twig', [
            'post_categories' => $postCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_categorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PostCategoryRepository $postCategoryRepository): Response
    {
        $postCategory = new PostCategory();
        $form = $this->createForm(PostCategory2Type::class, $postCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postCategoryRepository->save($postCategory, true);

            return $this->redirectToRoute('app_admin_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/categorie/new.html.twig', [
            'post_category' => $postCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_categorie_show', methods: ['GET'])]
    public function show(PostCategory $postCategory): Response
    {
        return $this->render('admin/categorie/show.html.twig', [
            'post_category' => $postCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_categorie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PostCategory $postCategory, PostCategoryRepository $postCategoryRepository): Response
    {
        $form = $this->createForm(PostCategory2Type::class, $postCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postCategoryRepository->save($postCategory, true);

            return $this->redirectToRoute('app_admin_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/categorie/edit.html.twig', [
            'post_category' => $postCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_categorie_delete', methods: ['POST'])]
    public function delete(Request $request, PostCategory $postCategory, PostCategoryRepository $postCategoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$postCategory->getId(), $request->request->get('_token'))) {
            $postCategoryRepository->remove($postCategory, true);
        }

        return $this->redirectToRoute('app_admin_categorie_index', [], Response::HTTP_SEE_OTHER);
    }
}
