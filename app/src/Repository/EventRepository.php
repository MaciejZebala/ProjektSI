<?php
/**
 * Event Repository.
 */

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Event;
use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
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
            ->join('event.category', 'category')
            ->leftJoin('event.tag', 'tag')
            ->orderBy('event.date', 'DESC');
        $queryBuilder = $this->applyFiltersToList($queryBuilder, $filters);

        return $queryBuilder;
    }

    /**
     * Query all records.
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function getCurrentEvents($dateObj): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->andWhere('event.date = :date')
            ->setParameter('date', $dateObj)
            ->orderBy('event.date', 'DESC');
    }

    /**
     * Query all records.
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function getComingEvents($dateObj, $nextThreeDays): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->andWhere('event.date > :date AND event.date <= :threeDays')
            ->setParameter('date', $dateObj)
            ->setParameter('threeDays', $nextThreeDays)
            ->orderBy('event.date', 'ASC');
    }

//    /**
//     * Query tasks by author.
//     *
//     * @param array            $filters Filters array
//     *
//     * @return \Doctrine\ORM\QueryBuilder Query builder
//     */
//    public function queryByAuthor(array $filters = []): QueryBuilder
//    {
//        $queryBuilder = $this->queryAll($filters);
//        $queryBuilder->andWhere('task.author = :author')
//            ->setParameter('author', $user);
//
//        return $queryBuilder;
//    }

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

    // /**
    //  * @return Event[] Returns an array of Event objects
    //  */

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
