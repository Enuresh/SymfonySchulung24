<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function getEventsByDate
    (
        ?\DateTimeImmutable $startDate = null,
        ?\DateTimeImmutable $endDate = null
    ): array
    {
        if ($startDate === null && $endDate === null)
        {
            throw new \InvalidArgumentException('Start date or end date must not be empty.');
        }

        $queryBuilder = $this->createQueryBuilder('e')->select('e');

        if ($endDate !== null)
        {
            $queryBuilder
                ->where('e.startAt >= :startDate')
                ->setParameter('startDate', $startDate)
            ;
        }
        elseif ($startDate !== null)
        {
            $queryBuilder->where('e.endAt <= :endDate')
            ->setParameter('endDate', $endDate)
            ;
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function searchLike(string $name): array
    {
        $queryBuilder = $this->createQueryBuilder('e');

        return $queryBuilder
            ->andWhere($queryBuilder->expr()->like('e.name', ':name'))
            ->setParameter('name', sprintf("%%%s%%", $name))
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Event[] Returns an array of Event objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Event
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
