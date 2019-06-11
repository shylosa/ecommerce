<?php
namespace App\Repository;
use App\Entity\AttributeCase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
/**
 * @method AttributeCase|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttributeCase|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttributeCase[]    findAll()
 * @method AttributeCase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttributeCaseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AttributeCase::class);
    }
    // /**
    //  * @return AttributeCase[] Returns an array of AttributeCase objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    /*
    public function findOneBySomeField($value): ?AttributeCase
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}