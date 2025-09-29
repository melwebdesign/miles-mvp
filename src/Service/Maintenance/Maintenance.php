<?php

declare(strict_types=1);

namespace App\Service\Maintenance;

use App\Entity\Vehicle;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Connection;


final readonly class Maintenance
{

    public function __construct(
        private EntityManagerInterface $em,
        private Connection $connection,
    )
    {

    }

    public function loadFixtures(): bool
    {
        $this->truncateAllTables();

        foreach ($this->getSampleData() as $entity) {
            $this->em->persist($entity);
        }

        $this->em->flush();

        return true;
    }

    private function getSampleData(): array
    {
        return [
            new Vehicle('Ford Puma (155)', 'Ford', 'Puma', 2023, 399, 'https://abo.miles-mobility.com/media/437/download/Ford_Puma-155_diagonal_left.jpg?v=1', 5, 5, 'Automatic', 'Petrol', 155, '2WD', 'SUV', 18, 900, 500),
            new Vehicle('Audi A4', 'Audi', 'A4 Avant', 2023, 548, 'https://abo.miles-mobility.com/media/290/download/Audi_A4_avant_diagonal-left.jpg?v=1', 5, 5, 'Automatic', 'Petrol', 146, '2WD', 'Station Wagon', 23, 900, 500),
            new Vehicle('VW Polo', 'VW', 'Polo', 2023, 387, 'https://abo.miles-mobility.com/media/249/download/VW_Polo_diagonal_left.jpg', 5, 5, 'Automatic', 'Petrol', 95, '2WD', 'Small Car', 18, 900, 500),
            new Vehicle('Jeep Compass Schwarz', 'Jeep', 'Compass', 2023, 499, 'https://abo.miles-mobility.com/media/505/download/4Q0A9139.jpg', 5, 5, 'Automatic', 'Plug-in Hybrid', 240, '4WD', 'SUV', 18, 1000, 500),
            new Vehicle('VW Tiguan', 'VW', 'Tiguan', 2023, 548, 'https://abo.miles-mobility.com/media/351/download/VW_Tiguan_diagonal-front.jpg', 5, 5, 'Automatic', 'Petrol', 150, '2WD', 'SUV', 23, 900, 500),
            new Vehicle('Opel Mokka-e Voltaik Blau Metallic', 'Opel', 'Mokka-e', 2023, 399, 'https://abo.miles-mobility.com/media/540/download/4Q0A9153.jpg', 5, 5, 'Automatic', 'Electric', 100, '2WD', 'SUV', 18, 1000, 500),
            new Vehicle('Tesla Model 3 (RWD)', 'Tesla', 'Model 3 (RWD)', 2023, 669, 'https://abo.miles-mobility.com/media/303/download/MILES_Tesla-Model-3_diagonal.jpg', 5, 4, 'Automatic', 'Electric', 325, '2WD', 'Sedan', 23, 1000, 500),
            new Vehicle('Opel Mokka-e Kontrast Grau Metallic', 'Opel', 'Mokka-e', 2023, 399, 'https://abo.miles-mobility.com/media/530/download/4Q0A9153.jpg', 5, 5, 'Automatic', 'Electric', 100, '2WD', 'SUV', 18, 1000, 500),
            new Vehicle('Audi A4 Avant S-line', 'Audi', 'A4 S-line', 2023, 749, 'https://abo.miles-mobility.com/media/391/download/Audi_A4_s-line_diagonal.jpg', 5, 5, 'Automatic', 'Petrol', 146, '2WD', 'Station Wagon', 23, 900, 500),
            new Vehicle('Jeep Compass Graphite Grey', 'Jeep', 'Compass', 2023, 499, 'https://abo.miles-mobility.com/media/511/download/4Q0A9139.jpg', 5, 5, 'Automatic', 'Plug-in Hybrid', 240, '4WD', 'SUV', 18, 1000, 500),
        ];
    }

    private function truncateAllTables(): void
    {
        $platform = $this->connection->getDatabasePlatform();

        $this->connection->executeStatement('SET FOREIGN_KEY_CHECKS = 0');

        $schemaManager = $this->connection->createSchemaManager();
        $tables = $schemaManager->listTableNames();

        foreach ($tables as $table) {
            $sql = $platform->getTruncateTableSQL($table);
            $this->connection->executeStatement($sql);
        }

        $this->connection->executeStatement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
