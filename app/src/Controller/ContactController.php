<?php

/**
 * Contact Controller
 */
namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use App\Service\ContactService;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EventController.
 *
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    /**
     * Contact service.
     *
     * @var \App\Service\ContactService
     */
    private $contactService;

    /**
     * CategoryController constructor.
     *
     * @param \App\Service\ContactService $contactService Contact service
     */
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * Index Action.
     *
     * @param Request $request HTTP Request
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="contact_index",
     *     )
     */
    public function index(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);

        $pagination = $this->contactService->createPaginatedList($page, $this->getUser(), $request->query->getAlnum('filters', []));

        return $this->render('contact/index.html.twig', [
            'pagination' => $pagination,
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
     *
     * @IsGranted(
     *  "VIEW",
     *  subject="contact",
     * )
     */
    public function show(Contact $contact): Response
    {
        if ($contact->getUser() !== $this->getUser()) {
            $this->addFlash('warning', 'message.item_not_found');

            return $this->redirectToRoute('contact_index');
        }

        return $this->render(
            'contact/show.html.twig',
            [
                'contact' => $contact,
            ]
        );
    }

    /**
     * Create action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="contact_create",
     * )
     */
    public function create(Request $request): Response
    {
        $contact = new Contact();
        $contact->setUser($this->getUser());
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->contactService->save($contact);
            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('contact_index');
        }

        return $this->render(
            'contact/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Contact                       $contact Contact entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="contact_edit",
     * )
     *
     * @IsGranted(
     *  "EDIT",
     *  subject="contact",
     * )
     */
    public function edit(Request $request, Contact $contact): Response
    {
        $form = $this->createForm(ContactType::class, $contact, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->contactService->save($contact);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('contact_index');
        }

        return $this->render(
            'contact/edit.html.twig',
            [
                'form' => $form->createView(),
                'contact' => $contact,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Entity\Contact                       $contact Contact entity
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="contact_delete",
     * )
     *
     * @IsGranted(
     *  "DELETE",
     *  subject="contact",
     * )
     */
    public function delete(Request $request, Contact $contact): Response
    {
        $form = $this->createForm(FormType::class, $contact, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->contactService->delete($contact);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('contact_index');
        }

        return $this->render(
            'contact/delete.html.twig',
            [
                'form' => $form->createView(),
                'contact' => $contact,
            ]
        );
    }
}
