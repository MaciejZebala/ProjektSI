<?php
/**
 * Home Page service.
 */

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\EventRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class HomePageService.
 */
class HomePageService
{
    /**
     * Event repository.
     *
     * @var \App\Repository\EventRepository
     */
    private $eventRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface
     */
    private $paginator;

    /**
     * HomePageService constructor.
     *
     * @param \App\Repository\EventRepository      $eventRepository Event repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator          Paginator
     */
    public function __construct(EventRepository $eventRepository, PaginatorInterface $paginator)
    {
        $this->eventRepository = $eventRepository;
        $this->paginator = $paginator;
    }

    /**
     * Create paginated list.
     *
     * @param int $page Page number
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface Paginated list
     */
    public function createPaginatedCurrentList(int $page, string $date): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->eventRepository->getCurrentEvents($date),
            $page,
            CategoryRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Create paginated list.
     *
     * @param int $page Page number
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface Paginated list
     */
    public function createPaginatedComingList(int $page, string $dateToday, string $dateNextThreeDays): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->eventRepository->getComingEvents($dateToday, $dateNextThreeDays),
            $page,
            CategoryRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save category.
     *
     * @param \App\Entity\Category $category Category entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Category $category): void
    {
        $this->categoryRepository->save($category);
    }

    /**
     * Delete category.
     *
     * @param \App\Entity\Category $category Category entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Category $category): void
    {
        $this->categoryRepository->delete($category);
    }

    /**
     * Find category by Id.
     *
     * @param int $id Category Id
     *
     * @return \App\Entity\Category|null Category entity
     */
    public function findOneById(int $id): ?Category
    {
        return $this->categoryRepository->findOneById($id);
    }
}
