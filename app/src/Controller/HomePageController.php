<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomePageController.
 *
 * @Route("/home")
 */
class HomePageController extends AbstractController
{
    /**
     * Index Action.
     *
     * @param \App\Repository\CategoryRepository $eventRepository Category repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="home_page_index",
     *     )
     */
    public function index(Request $request, EventRepository $eventRepository, PaginatorInterface $paginator): Response
    {
        $dateObj = date('Y-m-d');
        $nextThreeDays = date('Y-m-d', strtotime('+3 day'));

        $paginationCurrent = $paginator->paginate(
            $eventRepository->getCurrentEvents($dateObj),
            $request->query->getInt('page', 1)
        );

        $paginationComing = $paginator->paginate(
            $eventRepository->getComingEvents($dateObj, $nextThreeDays),
            $request->query->getInt('page', 1)
        );

//        $currentEvent = $eventRepository->getCurrentEvents($dateObj)->getQuery()->getResult();
//        $comingEvent = $eventRepository->getComingEvents($dateObj, $nextThreeDays)->getQuery()->getResult();

        return $this->render('home_page/index.html.twig', [
            'paginationComing' => $paginationComing,
            'paginationCurrent' => $paginationCurrent,
        ]);
    }
}
