<?php

namespace App\Repository;

use App\Entity\ArticleTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ArticleTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticleTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticleTranslation[]    findAll()
 * @method ArticleTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleTranslationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ArticleTranslation::class);
    }

    // /**
    //  * @return ArticleTranslation[] Returns an array of ArticleTranslation objects
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
    public function findOneBySomeField($value): ?ArticleTranslation
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
