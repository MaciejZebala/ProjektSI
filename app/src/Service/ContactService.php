<?php
/**
 * Contact service.
 */

namespace App\Service;

use App\Entity\Category;
use App\Entity\Contact;
use App\Repository\CategoryRepository;
use App\Repository\ContactRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

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
     * ContactService constructor.
     *
     * @param \App\Repository\ContactRepository      $contactRepository Contact repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator          Paginator
     */
    public function __construct(ContactRepository $contactRepository, PaginatorInterface $paginator)
    {
        $this->contactRepository = $contactRepository;
        $this->paginator = $paginator;
    }

    /**
     * Create paginated list.
     *
     * @param int $page Page number
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->contactRepository->queryAll(),
            $page,
            ContactRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Create paginated list.
     *
     * @param int $page Page number
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface Paginated list
     */
    public function createPaginatedShowList(int $page, $items): PaginationInterface
    {
        return $this->paginator->paginate(
            $items,
            $page,
            ContactRepository::PAGINATOR_ITEMS_PER_PAGE
        );
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
}
