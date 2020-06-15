<?php
/**
 * RedirectToRoute controller.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RedirectToRouteController.
 *
 * @Route("/")
 */
class RedirectToRouteController extends AbstractController
{
    /**
     * Index action.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse RedirectResponse
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="redirect_to_login",
     * )
     */
    public function index(): RedirectResponse
    {
        return $this->redirectToRoute('app_login');
    }
}
