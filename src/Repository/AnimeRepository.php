<?php

namespace App\Repository;

use App\Entity\Anime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AnimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Anime::class);
    }

    /**
     * Fetch all animes
     * 
     * @return Anime[]
     */
    public function findAllAnimes(): array
    {
        return $this->createQueryBuilder('a')
        ->orderBy('a.updatedAt', 'DESC')
        ->setMaxResults(36)
        ->getQuery()
        ->getResult();
    }
}
