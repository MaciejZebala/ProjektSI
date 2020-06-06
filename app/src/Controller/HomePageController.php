<?php
namespace App\Controller;

use App\Service\HomePageService;
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
* HomePage service.
*
* @var \App\Service\HomePageService
*/
    private $homePageService;
/**
* HomePageController constructor.
*
* @param \App\Service\HomePageService $homePageService HomePage service
*/
    public function __construct(HomePageService $homePageService)
    {
        $this->homePageService = $homePageService;
    }
/**
* Index Action.
*
* @return \Symfony\Component\HttpFoundation\Response HTTP response
*
* @Route(
*     "/",
*     methods={"GET"},
*     name="home_page_index",
*     )
*/
    public function index(Request $request): Response
    {
        $dateObj = date('Y-m-d');
        $nextThreeDays = date('Y-m-d', strtotime('+3 day'));
        $page = $request->query->getInt('page', 1);
        $paginationCurrent = $this->homePageService->createPaginatedCurrentList($page, $this->getUser(), $dateObj);
        $paginationComing = $this->homePageService->createPaginatedComingList($page, $this->getUser() , $dateObj, $nextThreeDays);

        return $this->render('home_page/index.html.twig', [
            'paginationComing' => $paginationComing,
            'paginationCurrent' => $paginationCurrent,
        ]);
    }
}
