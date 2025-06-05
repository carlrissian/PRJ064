<?php

namespace ImportSystem\Vehicle\Infrastructure;

use Faker\Factory;


use ImportSystem\Vehicle\Domain\Vehicle;
use ImportSystem\Vehicle\Domain\VehicleCollection;
use ImportSystem\Vehicle\Domain\VehicleGetByResponse;
use ImportSystem\Vehicle\Domain\VehicleCriteria;
use ImportSystem\Vehicle\Domain\VehicleRepository;
use ImportSystem\Vehicle\Domain\VehicleStatus;

class VehicleRepositoryFake implements VehicleRepository
{

    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function getBy(VehicleCriteria $criteria): VehicleGetByResponse
    {
        $count = 10;

        $objectArray = [];
        for ($i = $count; $i > 0; $i--) {
            $et = $this->create($i);
            $objectArray[] = $et;
        }

        $collection = new VehicleCollection($objectArray);

        //return new VehicleGetByResponse($collection, $totalRows);
        return new VehicleGetByResponse($collection);
    }

    public function create(
        $matricula = null
    ): Vehicle {
        return new Vehicle(
            null,
            $this->faker->randomElement(['1234BCD', '4567FGH', '8901JKL', '2345MNP', '6789QRS']) , //matricula
            $this->faker->randomElement([
                new VehicleStatus(1, 'AVAILABLE'),
                new VehicleStatus(2,'ON_RENT'),
                new VehicleStatus(3,'PENDING_REPAIR')
            ]), //estado
            $this->faker->numberBetween(1, 350000), // Kms actuales
            $this->faker->numberBetween(1, 110), // Combustible
            $this->faker->randomFloat() // Batería
        );
    }

    public function update(Vehicle $vehicle): int
    {
        return 1;
    }

}