<?php

namespace App\Repository;

use App\Entity\Training;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TrainingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Training::class);
    }

    public function add(Training $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function remove(Training $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findBySearch(string $search)
    {
        $query = $this->_em->createQuery(
            'SELECT t
            FROM App\Entity\Training t
            WHERE t.title LIKE :search OR t.description LIKE :search
            ORDER BY t.createdAt DESC'
        )->setParameter('search', '%'.$search.'%');

        return $query->getResult();
    }
}
