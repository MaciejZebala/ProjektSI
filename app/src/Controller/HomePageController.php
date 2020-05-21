<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class HomePageController
 *
 * @Route("/home")
 *
 */

class HomePageController extends AbstractController
{
    /**
     *
     * Index Action
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
    public function index(Request $request, EventRepository $eventRepository): Response
    {
        $dateObj = date('Y-m-d');
        $nextThreeDays = date("Y-m-d", strtotime("+3 day"));

        $currentEvent = $eventRepository->getCurrentEvents($dateObj)->getQuery()->getResult();
        $comingEvent = $eventRepository->getComingEvents($dateObj, $nextThreeDays)->getQuery()->getResult();


        return $this->render('home_page/index.html.twig', [
            'currentEvents' => $currentEvent,
            'comingEvents' => $comingEvent
        ]);
    }
}
