<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $make = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column]
    private ?int $productionYear = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column]
    private ?int $seats = null;

    #[ORM\Column]
    private ?int $doors = null;

    #[ORM\Column(length: 255)]
    private ?string $gearbox = null;

    #[ORM\Column(length: 255)]
    private ?string $vehicleType = null;

    #[ORM\Column(length: 255)]
    private ?int $power = null;

    #[ORM\Column(length: 5)]
    private ?string $powertrain = null;

    #[ORM\Column(length: 20)]
    private ?string $bodyType = null;

    #[ORM\Column]
    private ?int $minimumDriverAge = null;

    #[ORM\Column]
    private ?int $insuranceDeductible = null;

    #[ORM\Column]
    private ?int $mileage = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    /**
     * @param string|null $name
     * @param string|null $make
     * @param string|null $model
     * @param int|null $productionYear
     * @param int|null $price
     * @param string|null $image
     * @param int|null $seats
     * @param int|null $doors
     * @param string|null $gearbox
     * @param string|null $vehicleType
     * @param int|null $power
     * @param string|null $powertrain
     * @param string|null $bodyType
     * @param int|null $minimumDriverAge
     * @param int|null $insuranceDeductible
     * @param int|null $mileage
     */
    public function __construct(?string $name, ?string $make, ?string $model, ?int $productionYear, ?int $price, ?string $image, ?int $seats, ?int $doors, ?string $gearbox, ?string $vehicleType, ?int $power, ?string $powertrain, ?string $bodyType, ?int $minimumDriverAge, ?int $insuranceDeductible, ?int $mileage)
    {
        $this->name = $name;
        $this->make = $make;
        $this->model = $model;
        $this->productionYear = $productionYear;
        $this->price = $price;
        $this->image = $image;
        $this->seats = $seats;
        $this->doors = $doors;
        $this->gearbox = $gearbox;
        $this->vehicleType = $vehicleType;
        $this->power = $power;
        $this->powertrain = $powertrain;
        $this->bodyType = $bodyType;
        $this->minimumDriverAge = $minimumDriverAge;
        $this->insuranceDeductible = $insuranceDeductible;
        $this->mileage = $mileage;
        $this->status = 'active';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getMake(): ?string
    {
        return $this->make;
    }

    public function setMake(string $make): static
    {
        $this->make = $make;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getProductionYear(): ?int
    {
        return $this->productionYear;
    }

    public function setProductionYear(int $productionYear): static
    {
        $this->productionYear = $productionYear;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getSeats(): ?int
    {
        return $this->seats;
    }

    public function setSeats(int $seats): static
    {
        $this->seats = $seats;

        return $this;
    }

    public function getDoors(): ?int
    {
        return $this->doors;
    }

    public function setDoors(int $doors): static
    {
        $this->doors = $doors;

        return $this;
    }

    public function getGearbox(): ?string
    {
        return $this->gearbox;
    }

    public function setGearbox(string $gearbox): static
    {
        $this->gearbox = $gearbox;

        return $this;
    }

    public function getVehicleType(): ?string
    {
        return $this->vehicleType;
    }

    public function setVehicleType(string $vehicleType): static
    {
        $this->vehicleType = $vehicleType;

        return $this;
    }

    public function getPower(): ?int
    {
        return $this->power;
    }

    public function setPower(int $power): static
    {
        $this->power = $power;

        return $this;
    }

    public function getPowertrain(): ?string
    {
        return $this->powertrain;
    }

    public function setPowertrain(string $powertrain): static
    {
        $this->powertrain = $powertrain;

        return $this;
    }

    public function getBodyType(): ?string
    {
        return $this->bodyType;
    }

    public function setBodyType(string $bodyType): static
    {
        $this->bodyType = $bodyType;

        return $this;
    }

    public function getMinimumDriverAge(): ?int
    {
        return $this->minimumDriverAge;
    }

    public function setMinimumDriverAge(int $minimumDriverAge): static
    {
        $this->minimumDriverAge = $minimumDriverAge;

        return $this;
    }

    public function getInsuranceDeductible(): ?int
    {
        return $this->insuranceDeductible;
    }

    public function setInsuranceDeductible(int $insuranceDeductible): static
    {
        $this->insuranceDeductible = $insuranceDeductible;

        return $this;
    }

    public function getMileage(): ?int
    {
        return $this->mileage;
    }

    public function setMileage(int $mileage): static
    {
        $this->mileage = $mileage;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'make' => $this->make,
            'model' => $this->model,
            'productionYear' => $this->productionYear,
            'price' => $this->price,
            'image' => $this->image,
            'seats' => $this->seats,
            'doors' => $this->doors,
            'gearbox' => $this->gearbox,
            'vehicleType' => $this->vehicleType,
            'power' => $this->power,
            'powertrain' => $this->powertrain,
            'bodyType' => $this->bodyType,
            'minimumDriverAge' => $this->minimumDriverAge,
            'insuranceDeductible' => $this->insuranceDeductible,
            'mileage' => $this->mileage,
        ];
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }
}
