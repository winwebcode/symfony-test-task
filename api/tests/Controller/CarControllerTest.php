<?php

namespace App\Tests\carController;

use App\Controller\CarController;
use App\Entity\Car;
use App\Entity\Brand;
use App\Entity\Model;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\SerializerInterface;

class CarControllerTest extends KernelTestCase
{

    private $carRepository;

    private $serializer;

    private $carController;

    private $testCar;

    private $expectedJson;

    protected function setUp(): void
    {
        $this->carRepository = $this->createMock(CarRepository::class);
        $this->serializer    = $this->createMock(SerializerInterface::class);
        $this->carController = new CarController();
        $this->testCar       = $this->createTestCar();
        $this->expectedJson  = json_encode([
            'id'    => 1,
            'brand' => 'BMW',
            'model' => 'X5',
            'price' => 4500000,
            'photo' => 'https://testdomain.com/photo.jpg'
        ]);
    }


    private function createTestCar(): Car
    {
        $brand = new Brand();
        $brand->setName('BMW');
        $this->setEntityId($brand, 1);

        $model = new Model();
        $model->setName('X5');
        $model->setBrand($brand);
        $this->setEntityId($model, 1);

        $car = new Car();
        $car->setBrand($brand)
            ->setModel($model)
            ->setPrice(4500000)
            ->setPhoto('https://testdomain.com/photo.jpg');
        $this->setEntityId($car, 1);

        return $car;
    }


    //Set ID for entity using Reflection
    private function setEntityId(object $entity, int $id): void
    {
        $reflection = new \ReflectionClass(get_class($entity));
        $property   = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($entity, $id);
    }

    public function testList(): void
    {
        $this->carRepository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([$this->testCar]);

        $this->serializer
            ->expects($this->once())
            ->method('serialize')
            ->willReturn(json_encode([$this->expectedJson]));

        // Call carController method and assert response
        $response = $this->carController->list($this->carRepository, $this->serializer);
        $this->assertSuccessfulJsonResponse($response);
    }

    public function testShow(): void
    {
        $this->carRepository
            ->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($this->testCar);

        $this->serializer
            ->expects($this->once())
            ->method('serialize')
            ->willReturn($this->expectedJson);

        $response = $this->carController->show(1, $this->carRepository, $this->serializer);
        $this->assertSuccessfulJsonResponse($response);
    }

    public function testShowNotFound(): void
    {
        $this->carRepository
            ->expects($this->once())
            ->method('find')
            ->with(999)
            ->willReturn(null);

        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage('Car not found');
        $this->carController->show(999, $this->carRepository, $this->serializer);
    }

    private function assertSuccessfulJsonResponse($response): void
    {
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertJson($response->getContent());
    }
} 