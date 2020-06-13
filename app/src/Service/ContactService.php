<?php
/**
 * Contact service.
 */

namespace App\Service;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class ContactService.
 */
class ContactService
{
    /**
     * Contact repository.
     *
     * @var \App\Repository\ContactRepository
     */
    private $contactRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface
     */
    private $paginator;

    /**
     * Tag service.
     *
     * @var \App\Service\TagService
     */
    private $tagService;

    /**
     * ContactService constructor.
     *
     * @param \App\Repository\ContactRepository       $contactRepository Contact repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator         Paginator
     * @param TagService                              $tagService        Tag Service
     */
    public function __construct(ContactRepository $contactRepository, PaginatorInterface $paginator, TagService $tagService)
    {
        $this->contactRepository = $contactRepository;
        $this->paginator = $paginator;
        $this->tagService = $tagService;
    }

    /**
     * Create paginated list.
     *
     * @param int           $page    Page number
     * @param UserInterface $user
     * @param array         $filters
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page, UserInterface $user, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->contactRepository->queryByAuthor($user, $filters),
            $page,
            ContactRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * @param UserInterface $user
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getUserCategories(UserInterface $user)
    {
        return $this->contactRepository->queryUserCategory($user)->getQuery()->getResult();
    }

    /**
     * Save category.
     *
     * @param \App\Entity\Contact $contact Contact entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Contact $contact): void
    {
        $this->contactRepository->save($contact);
    }

    /**
     * Delete category.
     *
     * @param \App\Entity\Contact $contact Contact entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Contact $contact): void
    {
        $this->contactRepository->delete($contact);
    }

    /**
     * @param array $filters
     *
     * @return array
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (isset($filters['tag']) && is_numeric($filters['tag'])) {
            $tag = $this->tagService->findOneById($filters['tag']);
            if (null !== $tag) {
                $resultFilters['tag'] = $tag;
            }
        }

        return $resultFilters;
    }
}
