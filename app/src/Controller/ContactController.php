<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EventController
 *
 * @Route("/contact")
 *
 */
class ContactController extends AbstractController
{
    /**
     *
     * Index Action
     *
     * @param \App\Repository\ContactRepository $contactRepository Contact repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="contact_index",
     *     )
     */
    public function index(Request $request, ContactRepository $contactRepository, PaginatorInterface $paginator): Response
    {
        $page = $request->query->getInt('page', 1);

        $pagination = $paginator->paginate($contactRepository->queryAll(), $page, ContactRepository::PAGINATOR_ITEMS_PER_PAGE);

        return $this->render('contact/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Show action.
     *
     * @param \App\Entity\Contact $contact Contact entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="contact_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */

    public function show(Request $request, Contact $contact, ContactRepository $contactRepository,PaginatorInterface $paginator): Response
    {

//        $details = $contactRepository->queryAll();

        $pagination = $paginator->paginate(
            $contact->getEvents(),
            $request->query->getInt('page', 1)
        );
        return $this->render(
            'contact/show.html.twig',
            [
                'pagination' => $pagination,
                'contact' => $contact
            ]
        );
    }
}
