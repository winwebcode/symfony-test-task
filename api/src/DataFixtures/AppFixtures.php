<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Model;
use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $carsData = [
            'BMW'      => [
                'models' => ['X5', 'X6', '5 Series'],
                'prices' => [4500000, 5200000, 4800000]
            ],
            'Mercedes' => [
                'models' => ['GLE', 'S-Class', 'C-Class'],
                'prices' => [6500000, 8500000, 3800000]
            ],
            'Audi'     => [
                'models' => ['Q7', 'A6', 'A8'],
                'prices' => [5800000, 4200000, 7500000]
            ],
            'Toyota'   => [
                'models' => ['Camry', 'RAV4', 'Land Cruiser'],
                'prices' => [2800000, 3500000, 6800000]
            ]
        ];

        foreach ($carsData as $brandName => $data) {
            $brand = new Brand();
            $brand->setName($brandName);
            $manager->persist($brand);

            foreach ($data['models'] as $index => $modelName) {
                $model = new Model();
                $model->setName($modelName);
                $model->setBrand($brand);
                $manager->persist($model);

                $car = new Car();
                $car->setBrand($brand)
                    ->setModel($model)
                    ->setPhoto('https://media-storage-local.dev/photos/' . trim($modelName) . '.jpg')
                    ->setPrice($data['prices'][$index]);
                $manager->persist($car);
            }
        }

        $manager->flush();
    }
}