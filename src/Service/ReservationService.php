<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Reservation;
use App\Entity\Vehicle;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class ReservationService
{

    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {

    }

    public function createReservation(int $vehicleId, \DateTimeImmutable $startDate, \DateTimeImmutable $endDatetime, string $pickupCity, string $returnCity, bool $returnAtDifferentLocation): Reservation
    {
        $this->entityManager->beginTransaction();

        try {
            $vehicle = $this->entityManager->find(Vehicle::class, $vehicleId, LockMode::PESSIMISTIC_WRITE);
            if (null === $vehicle) {
                throw new EntityNotFoundException('Vehicle not found');
            }

            $hasOverlap = $this->entityManager->getRepository(Reservation::class)->hasOverlap($vehicle->getId(), $startDate, $endDatetime);
            if ($hasOverlap) {
                throw new \LogicException('Has overlap');
            }

            $reservation = new Reservation($vehicle, $startDate, $endDatetime, $pickupCity, $returnCity, $returnAtDifferentLocation);
            $this->entityManager->persist($reservation);
            $this->entityManager->flush();
            $this->entityManager->commit();

            return $reservation;
        } catch (\Throwable $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }

    public function showReservation(int $reservationId): Reservation
    {
        $reservation = $this->entityManager->getRepository(Reservation::class)->find($reservationId);
        if (null === $reservation) {
            throw new EntityNotFoundException('Reservation not found');
        }
        return $reservation;
    }

    public function showReservations(): array
    {
        return $this->entityManager->getRepository(Reservation::class)->findAll();
    }

    public function deleteReservation(int $reservationId): Reservation
    {
        $reservation = $this->entityManager->getRepository(Reservation::class)->find($reservationId);
        if (null === $reservation) {
            throw new EntityNotFoundException('Reservation not found');
        }

        if ($reservation->getStatus() === 'deleted') {
            return $reservation;
        }

        $reservation->setStatus('deleted');
        $this->entityManager->persist($reservation);

        return $reservation;
    }
}
