<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function hasOverlap(int $vehicleId, \DateTimeImmutable $newStart, \DateTimeImmutable $newEnd): bool
    {
        $conn = $this->getEntityManager()->getConnection();

        $startDate = $newStart->format('Y-m-d');
        $endDate = $newEnd->format('Y-m-d');

        $sql = <<<SQL
SELECT 1
FROM reservation
WHERE vehicle_id = :vehicleId
  AND status != :status
  AND DATE(pickup_datetime) <= :endDate
  AND DATE(return_datetime) >= :startDate
LIMIT 1
SQL;

        $result = $conn->executeQuery($sql, [
            'vehicleId' => $vehicleId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'status' => 'canceled',
        ])->fetchOne();

        return (bool)$result;
    }
}
