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
                'title'          => 'Standard',
                'interestRate'   => 2,
                'initialPayment' => 200000,
                'loanTerm'       => 60
            ],
            [
                'title'          => 'Economy',
                'interestRate'   => 8,
                'initialPayment' => 50000,
                'loanTerm'       => 360
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
