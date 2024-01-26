<?php

namespace App\Repository;

use App\Entity\Quotpart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Quotpart>
 *
 * @method Quotpart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quotpart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quotpart[]    findAll()
 * @method Quotpart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuotpartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quotpart::class);
    }

    public function save(Quotpart $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Quotpart $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Quotpart[] Returns an array of Quotpart objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('q.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Quotpart
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
