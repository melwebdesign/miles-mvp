<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Vehicle;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class VehicleService
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function getVehicles(\DateTimeImmutable $startDatetime, \DateTimeImmutable $endDatetime): array
    {
        return $this->entityManager->getRepository(Vehicle::class)->findAvailableVehicles($startDatetime, $endDatetime);
    }

    public function getVehicle(int $vehicleId): ?Vehicle
    {
        $vehicle = $this->entityManager->getRepository(Vehicle::class)->find($vehicleId);
        if (null === $vehicle) {
            throw new EntityNotFoundException('Vehicle not found');
        }

        return $vehicle;
    }

    public function deleteVehicle(int $id): bool
    {
        $vehicle = $this->getVehicle($id);
        $vehicle->setStatus('deleted');
        $this->entityManager->flush();

        return true;
    }
}
