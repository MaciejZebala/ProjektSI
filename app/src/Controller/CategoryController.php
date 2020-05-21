<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EventController
 *
 * @Route("/category")
 *
 */

class CategoryController extends AbstractController
{
    /**
     *
     * Index Action
     *
     * @param \App\Repository\CategoryRepository $categoryRepository Category repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="category_index",
     *     )
     */
    public function index(Request $request, CategoryRepository $categoryRepository, PaginatorInterface $paginator): Response
    {

        $page = $request->query->getInt('page', 1);

        $pagination = $paginator->paginate($categoryRepository->queryAll(), $page, CategoryRepository::PAGINATOR_ITEMS_PER_PAGE);

        return $this->render('category/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Category $category Category entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="category_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */

    public function show(Request $request, Category $category, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $category->getEvents(),
            $request->query->getInt('page', 1),
            3
        );
        return $this->render(
            'category/show.html.twig',
            ['pagination' => $pagination]
        );
    }
}
