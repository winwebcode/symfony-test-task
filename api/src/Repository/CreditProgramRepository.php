<?php

namespace App\Repository;

use App\Entity\CreditProgram;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @extends ServiceEntityRepository<CreditProgram>
 *
 * @method CreditProgram|null find($id, $lockMode = null, $lockVersion = null)
 * @method CreditProgram|null findOneBy(array $criteria, array $orderBy = null)
 * @method CreditProgram[]    findAll()
 * @method CreditProgram[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreditProgramRepository extends BaseRepository
{

    const STANDARD_PROGRAM_MONTHLY_LOAN_PAYMENT = 10000;
    const STANDARD_PROGRAM_NAME = 'Standard';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CreditProgram::class);
    }

    public function findSuitableProgram(float $initialPayment, int $loanTerm, float $monthlyLoanPayment): ?CreditProgram
    {
        $standardProgram = $this->findOneBy(['title' => self::STANDARD_PROGRAM_NAME]);

        if (!$standardProgram) {
            throw new Exception(self::STANDARD_PROGRAM_NAME . ' program not found');
        }

        if ($initialPayment > $standardProgram->getInitialPayment()
            && $monthlyLoanPayment <= self::STANDARD_PROGRAM_MONTHLY_LOAN_PAYMENT
            && $loanTerm <= $standardProgram->getLoanTerm()) {

            return $this->findOneBy(['title' => self::STANDARD_PROGRAM_NAME]);
        }

        $queryBuilder = $this->createQueryBuilder('cp');

        return $queryBuilder
            ->select()
            ->where("cp.title != :title")
            ->setParameter('title', self::STANDARD_PROGRAM_NAME)
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult();
    }

    //    /**
    //     * @return CreditProgram[] Returns an array of CreditProgram objects
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

    //    public function findOneBySomeField($value): ?CreditProgram
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
