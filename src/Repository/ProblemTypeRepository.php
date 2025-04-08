<?php

namespace App\Repository;

use App\Entity\ProblemType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProblemType>
 *
 * @method ProblemType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProblemType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProblemType[]    findAll()
 * @method ProblemType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProblemTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProblemType::class);
    }

    public function save(ProblemType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ProblemType $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
} 