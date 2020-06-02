<?php
/**
 * Admin Controller
 */

namespace App\Controller;

use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller
 */
class AdminController extends AbstractController
{
    /**
     * Users action.
     *
     * @param Request            $request    HTTP request
     * @param UserRepository     $userRepository User Repository
     * @param PaginatorInterface $paginator  Paginator
     *
     * @return Response
     *
     * @Route("/admin", name="admin_user")
     */
    public function showUser(Request $request, UserRepository $userRepository, PaginatorInterface $paginator): Response
    {
        $page = $request->query->getInt('page', 1);

        $pagination = $paginator->paginate($userRepository->queryAll(), $page, UserRepository::PAGINATOR_ITEMS_PER_PAGE);

        return $this->render('admin/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
//
//    /**
//     * @return Response
//     */
//    public function edit(): Response
//    {
//
//    }
}
