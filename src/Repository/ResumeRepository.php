<?php

namespace App\Repository;

use App\Entity\Resume;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Resume|null find($id, $lockMode = null, $lockVersion = null)
 * @method Resume|null findOneBy(array $criteria, array $orderBy = null)
 * @method Resume[]    findAll()
 * @method Resume[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResumeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Resume::class);
    }

    public function getAllSlides(string $locale = null): ?array
    {
        $query = $this->createQueryBuilder('r')
            ->addSelect('rt')
            ->leftJoin('r.resumeTranslations', 'rt');

        if($locale)
        $query->andWhere('rt.locale = :locale')
            ->setParameter('locale', $locale);

        return $query->getQuery()
                    ->getResult();
    }


}
