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
use Symfony\Component\Security\Core\User\UserInterface;

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
     * @param \App\Repository\EventRepository         $eventRepository Event repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator       Paginator
     */
    public function __construct(EventRepository $eventRepository, PaginatorInterface $paginator)
    {
        $this->eventRepository = $eventRepository;
        $this->paginator = $paginator;
    }

    /**
     * Create paginated list.
     *
     * @param int           $page Page number
     * @param UserInterface $user
     * @param string        $date
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface Paginated list
     */
    public function createPaginatedCurrentList(int $page, UserInterface $user, string $date): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->eventRepository->getCurrentEvents($date, $user),
            $page,
            CategoryRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Create paginated list.
     *
     * @param int           $page              Page number
     * @param UserInterface $user
     * @param string        $dateToday
     * @param string        $dateNextThreeDays
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface Paginated list
     */
    public function createPaginatedComingList(int $page, UserInterface $user, string $dateToday, string $dateNextThreeDays): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->eventRepository->getComingEvents($dateToday, $dateNextThreeDays, $user),
            $page,
            CategoryRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }
}
