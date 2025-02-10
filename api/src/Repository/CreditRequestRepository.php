<?php

namespace App\Repository;

use App\Entity\Car;
use App\Entity\CreditProgram;
use App\Entity\CreditRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CreditRequest>
 *
 * @method CreditRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method CreditRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method CreditRequest[]    findAll()
 * @method CreditRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreditRequestRepository extends BaseRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CreditRequest::class);
    }

    public function createRequest(
        Car           $car,
        CreditProgram $creditProgram,
        float         $initialPayment,
        int           $loanTerm
    ): CreditRequest {
        $request = new CreditRequest();
        $request->setCar($car)
            ->setCreditProgram($creditProgram)
            ->setInitialPayment($initialPayment)
            ->setLoanTerm($loanTerm);

        $this->getEntityManager()->persist($request);
        $this->getEntityManager()->flush();

        return $request;
    }

    //    /**
    //     * @return CreditRequest[] Returns an array of CreditRequest objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?CreditRequest
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
