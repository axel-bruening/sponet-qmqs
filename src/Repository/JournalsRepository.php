<?php

namespace App\Repository;

use App\Entity\Journals;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Journals>
 *
 * @method Journals|null find($id, $lockMode = null, $lockVersion = null)
 * @method Journals|null findOneBy(array $criteria, array $orderBy = null)
 * @method Journals[]    findAll()
 * @method Journals[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JournalsRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Journals::class);
  }

  public function add(Journals $entity, bool $flush = false): void
  {
    $this->getEntityManager()->persist($entity);

    if ($flush) {
      $this->getEntityManager()->flush();
    }
  }

  public function remove(Journals $entity, bool $flush = false): void
  {
    $this->getEntityManager()->remove($entity);

    if ($flush) {
      $this->getEntityManager()->flush();
    }
  }

//    /**
//     * @return Journals[] Returns an array of Journals objects
//     */
// SELECT COUNT(ID) AS Anzahl, titel, auswerter FROM `journals` WHERE titel != '' AND auswerter != '' AND datum >= '01.01.2016' GROUP BY titel, auswerter;
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('j.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Journals
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
