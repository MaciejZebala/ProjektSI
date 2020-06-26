<?php
/**
 * Event Repository.
 */

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Event;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Class EventRepository
 *
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    const PAGINATOR_ITEMS_PER_PAGE = 3;

    /**
     * EventRepository constructor.
     *
     * @param \Doctrine\Common\Persistence\ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * Query all records.
     *
     * @param array $filters Filters array
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryAll(array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->getOrCreateQueryBuilder()
            ->select(
                'partial event.{id, date, title}',
                'partial category.{id, title}',
                'partial tag.{id, name}'
            )
            ->leftJoin('event.category', 'category')
            ->leftJoin('event.tag', 'tag')
            ->orderBy('event.date', 'DESC');
        $queryBuilder = $this->applyFiltersToList($queryBuilder, $filters);

        return $queryBuilder;
    }

    /**
     * Query all records.
     *
     * @param Date $dateObj
     * @param User $user
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function getCurrentEvents($dateObj, User $user): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->andWhere('event.user = :author')
            ->andWhere('event.date = :date')
            ->setParameter('author', $user)
            ->setParameter('date', $dateObj)
            ->orderBy('event.date', 'DESC');
    }

    /**
     * Query all records.
     *
     * @param Date $dateObj
     * @param Date $nextThreeDays
     * @param User $user
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function getComingEvents($dateObj, $nextThreeDays, User $user): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->andWhere('event.user = :author')
            ->andWhere('event.date > :date AND event.date <= :threeDays')
            ->setParameter('date', $dateObj)
            ->setParameter('author', $user)
            ->setParameter('threeDays', $nextThreeDays)
            ->orderBy('event.date', 'ASC');
    }

    /**
     * Query tasks by author.
     *
     * @param \App\Entity\User $user    User entity
     * @param array            $filters Filters array
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryByAuthor(User $user, array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->queryAll($filters);

        $queryBuilder->andWhere('event.user = :author')
            ->setParameter('author', $user);

        return $queryBuilder;
    }

    /**
     * Save record.
     *
     * @param \App\Entity\Event $event event entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Event $event): void
    {
        $this->_em->persist($event);
        $this->_em->flush($event);
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\Event $event Category entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Event $event): void
    {
        $this->_em->remove($event);
        $this->_em->flush($event);
    }

    /**
     * Apply filters to paginated list.
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder
     * @param array                      $filters      Filters array
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    private function applyFiltersToList(QueryBuilder $queryBuilder, array $filters = []): QueryBuilder
    {
        if (isset($filters['category']) && $filters['category'] instanceof Category) {
            $queryBuilder->andWhere('category = :category')
                ->setParameter('category', $filters['category']);
        }

        if (isset($filters['tag']) && $filters['tag'] instanceof Tag) {
            $queryBuilder->andWhere('tag IN (:tag)')
                ->setParameter('tag', $filters['tag']);
        }

        return $queryBuilder;
    }

    /**
     * Get or create new query builder.
     *
     * @param \Doctrine\ORM\QueryBuilder|null $queryBuilder Query builder
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('event');
    }

//    public function findByExampleField($value)
//    {
//        return $this->createQueryBuilder('event')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
//
//
//
//    public function findOneBySomeField($value): ?Event
//    {
//        return $this->createQueryBuilder('event')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
