<?php

namespace App\Tests\carController;

use App\Controller\CarController;
use App\DTO\CarDto;
use App\Service\CarService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\SerializerInterface;

class CarControllerTest extends KernelTestCase
{

    private $carService;

    private $serializer;

    private $carController;

    private $testCarDto;

    private $expectedJson;

    protected function setUp(): void
    {
        $this->carService    = $this->createMock(CarService::class);
        $this->serializer    = $this->createMock(SerializerInterface::class);
        $this->carController = new CarController();
        $this->testCarDto    = $this->createMock(CarDto::class);
        $this->expectedJson  = json_encode([
            'id'    => 1,
            'brand' => 'BMW',
            'model' => 'X5',
            'price' => 4500000,
            'photo' => 'https://testdomain.com/photo.jpg'
        ]);
    }

    public function testList(): void
    {
        $carDtoArray = [$this->testCarDto];

        $this->carService
            ->expects($this->once())
            ->method('getAllCars')
            ->willReturn($carDtoArray);

        $this->serializer
            ->expects($this->once())
            ->method('serialize')
            ->willReturn(json_encode([$this->expectedJson]));

        // Call carController method and assert response
        $response = $this->carController->list($this->carService, $this->serializer);
        $this->assertSuccessfulJsonResponse($response);
    }

    public function testShow(): void
    {
        $this->carService
            ->expects($this->once())
            ->method('getCarById')
            ->with(1)
            ->willReturn($this->testCarDto);

        $this->serializer
            ->expects($this->once())
            ->method('serialize')
            ->willReturn($this->expectedJson);

        $response = $this->carController->show(1, $this->carService, $this->serializer);
        $this->assertSuccessfulJsonResponse($response);
    }

    public function testShowNotFound(): void
    {
        $this->carService
            ->expects($this->once())
            ->method('getCarById')
            ->with(999)
            ->willThrowException(new NotFoundHttpException('Car not found'));

        $response = $this->carController->show(999, $this->carService, $this->serializer);
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertJson($response->getContent());
        $this->assertStringContainsString('Car not found', $response->getContent());
    }

    private function assertSuccessfulJsonResponse($response): void
    {
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertJson($response->getContent());
    }
} 