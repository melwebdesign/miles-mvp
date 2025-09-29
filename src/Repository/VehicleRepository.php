<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Vehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vehicle>
 */
class VehicleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    public function findAvailableVehicles(\DateTimeImmutable $start, \DateTimeImmutable $end): array
    {
        $em = $this->getEntityManager();
        $conn = $em->getConnection();

        $startDate = $start->format('Y-m-d');
        $endDate = $end->format('Y-m-d');

        $sql = <<<SQL
SELECT v.id
FROM vehicle v
WHERE v.status = 'active' and v.id NOT IN (
    SELECT r.vehicle_id
    FROM reservation r
    WHERE DATE(r.pickup_datetime) <= :endDate
      AND DATE(r.return_datetime) >= :startDate
)
SQL;

        $vehicleIds = $conn->executeQuery($sql, [
            'startDate' => $startDate,
            'endDate' => $endDate,
        ])->fetchFirstColumn();

        if (empty($vehicleIds)) {
            return [];
        }

        return $em->getRepository(Vehicle::class)->findBy(['id' => $vehicleIds]);
    }
}
