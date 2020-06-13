<?php
/**
 * Admin Controller
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\UserPasswordType;
use App\Service\AdminService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AdminController
 *
 * @Route("/admin")
 *
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * Admin service.
     *
     * @var \App\Service\AdminService
     */
    private $adminService;

    /**
     * AdminController constructor.
     *
     * @param \App\Service\AdminService $adminService Admin service
     */
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * Users action.
     *
     * @param Request $request HTTP request
     *
     * @return Response
     *
     * @Route("/", name="admin_user")
     */
    public function showUser(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);

        $pagination = $this->adminService->createPaginatedList($page);

        return $this->render('admin/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * User Edit Password
     *
     * @param Request                      $request         HTTP Request
     * @param UserPasswordEncoderInterface $passwordEncoder Password Encoder
     * @param User                         $user            User Entity
     *
     * @return Response
     *
     * @Route(
     *     "/{id}/pass",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="admin_user_edit"
     * )
     */
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder, User $user): Response
    {
        $form = $this->createForm(UserPasswordType::class, $user, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $this->adminService->save($user);

            $this->addFlash('success', 'message.registered_successfully');

            return $this->redirectToRoute('admin_user');
        }

        return $this->render(
            'admin/edit.html.twig',
            ['form' => $form->createView(),
                'user' => $user, ]
        );
    }
}
