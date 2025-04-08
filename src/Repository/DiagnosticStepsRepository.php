<?php

namespace App\Repository;

use App\Entity\DiagnosticSteps;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DiagnosticSteps>
 *
 * @method DiagnosticSteps|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiagnosticSteps|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiagnosticSteps[]    findAll()
 * @method DiagnosticSteps[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiagnosticStepsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DiagnosticSteps::class);
    }

    public function save(DiagnosticSteps $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DiagnosticSteps $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return DiagnosticSteps[] Returns an array of DiagnosticSteps objects
     */
    public function findByProblemTypeOrdered($problemType): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.problemType = :problemType')
            ->setParameter('problemType', $problemType)
            ->orderBy('d.ordre', 'ASC')
            ->getQuery()
            ->getResult();
    }
} 