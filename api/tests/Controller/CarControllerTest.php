<?php

namespace App\Tests\carController;

use App\Controller\CarController;
use App\DTO\CarDto;
use App\Service\CarService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\SerializerInterface;

class CarControllerTest extends TestCase
{

    private const EXPECTED_DATA = [
        'id'    => 1,
        'brand' => 'BMW',
        'model' => 'X5',
        'price' => 4500000,
        'photo' => 'https://testdomain.com/bmw-x5.jpg'
    ];

    private CarService $carService;

    private SerializerInterface $serializer;

    private CarController $carController;

    private CarDto $testCarDto;

    private string $expectedJson;

    protected function setUp(): void
    {
        $this->carService    = $this->createMock(CarService::class);
        $this->serializer    = $this->createMock(SerializerInterface::class);
        $this->carController = new CarController();
        $this->testCarDto    = $this->createMock(CarDto::class);
        $this->expectedJson  = json_encode(self::EXPECTED_DATA);
    }

    public function test_List_WithValidData_ShouldReturnSuccessfulJsonResponse(): void
    {
        $carDtoArray            = [$this->testCarDto];
        $expectedSerializedData = json_encode([$this->expectedJson]);

        $this->carService
            ->expects($this->once())
            ->method('getAllCars')
            ->willReturn($carDtoArray);

        $this->serializer
            ->expects($this->once())
            ->method('serialize')
            ->with($carDtoArray, 'json')
            ->willReturn($expectedSerializedData);

        $response = $this->carController->list($this->carService, $this->serializer);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($expectedSerializedData, $response->getContent());
    }

    public function test_Show_WithExistingCar_ShouldReturnSuccessfulJsonResponse(): void
    {
        $carId = self::EXPECTED_DATA['id'];

        $this->carService
            ->expects($this->once())
            ->method('getCarById')
            ->with($carId)
            ->willReturn($this->testCarDto);

        $this->serializer
            ->expects($this->once())
            ->method('serialize')
            ->with($this->testCarDto, 'json')
            ->willReturn($this->expectedJson);

        $response = $this->carController->show($carId, $this->carService, $this->serializer);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals($this->expectedJson, $response->getContent());
    }

    public function test_Show_WithNonExistentCar_ShouldReturn404Response(): void
    {
        $nonExistentCarId     = 99999999;
        $expectedErrorMessage = 'Car not found';

        $this->carService
            ->expects($this->once())
            ->method('getCarById')
            ->with($nonExistentCarId)
            ->willThrowException(new NotFoundHttpException($expectedErrorMessage));

        $response = $this->carController->show($nonExistentCarId, $this->carService, $this->serializer);
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertStringContainsString($expectedErrorMessage, $response->getContent());
    }
} 