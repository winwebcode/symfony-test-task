<?php

namespace App\DataFixtures;

use App\Entity\CreditProgram;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CreditProgramFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $creditPrograms = [
            [
                'title'          => 'Стандарт',
                'interestRate'   => 12.3,
                'initialPayment' => 200000,
                'loanTerm'       => 60
            ],
            [
                'title'          => 'Люкс',
                'interestRate'   => 9.9,
                'initialPayment' => 500000,
                'loanTerm'       => 120
            ],
            [
                'title'          => 'Эконом',
                'interestRate'   => 30,
                'initialPayment' => 100000,
                'loanTerm'       => 36
            ]
        ];

        foreach ($creditPrograms as $programData) {
            $program = new CreditProgram();
            $program->setTitle($programData['title'])
                ->setInterestRate($programData['interestRate'])
                ->setInitialPayment($programData['initialPayment'])
                ->setLoanTerm($programData['loanTerm']);
            $manager->persist($program);
        }

        $manager->flush();
    }
}
