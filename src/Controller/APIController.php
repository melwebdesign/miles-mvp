<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\Maintenance\Maintenance;
use App\Service\ReservationService;
use App\Service\VehicleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: 'api:')]
final class APIController extends AbstractController
{
    public function __construct(
        private VehicleService     $vehicleService,
        private ReservationService $reservationService,
    )
    {

    }

    #[Route('/vehicles', name: 'vehicles:list', methods: ['GET'])]
    public function availability(
        #[MapQueryParameter] string $startDatetime = null,
        #[MapQueryParameter] string $endDatetime = null,
    ): Response
    {
        $startDatetime = (new \DateTimeImmutable($startDatetime))->setTime(8, 0);
        $endDatetime = (new \DateTimeImmutable($endDatetime))->setTime(19, 59);
        $errors = $this->validateDays($startDatetime, $endDatetime);
        if (0 < count($errors)) {
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->json($this->vehicleService->getVehicles($startDatetime, $endDatetime));
    }

    #[Route('/vehicles', name: 'vehicles:create', methods: ['POST'])]
    public function create(#[MapRequestPayload] $vehicle): Response
    {
        return $this->json(['create', $vehicle]);
    }

    #[Route('/vehicles/{id}', name: 'vehicles:show', methods: ['GET'])]
    public function show(int $id): Response
    {
        return $this->json($this->vehicleService->getVehicle($id));
    }

    #[Route('/vehicles/{id}', name: 'vehicles:update', methods: ['PATCH'])]
    public function update(#[MapQueryParameter] $id): Response
    {
        return $this->json(['vehicle' => $id]);
    }

    #[Route('/vehicles/{id}', name: 'vehicles:delete', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        $this->vehicleService->deleteVehicle($id);

        return $this->json(['OK']);
    }

    #[Route('/reservations', name: 'reservations:create', methods: ['POST'])]
    public function reservationCreate(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $vehicleId = $data['vehicleId'];
        $startDatetime = new \DateTimeImmutable($data['pickupDatetime']);
        $endDatetime = new \DateTimeImmutable($data['returnDatetime']);
        $pickupCity = $data['pickupCity'];
        $returnCity = $data['returnCity'];
        $returnAtDifferentLocation = $data['returnAtDifferentLocation'];

        $errors = $this->validateDays($startDatetime, $endDatetime);
        if (0 < count($errors)) {
            return $this->json($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $this->reservationService->createReservation($vehicleId, $startDatetime, $endDatetime, $pickupCity, $returnCity, $returnAtDifferentLocation);
        } catch (\LogicException $exception) {
            return $this->json('Car is already reserved for these dates', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->json(['OK']);
    }

    #[Route('/reservations', name: 'reservations:list', methods: ['GET'])]
    public function reservationsList(): Response
    {
        return $this->json($this->reservationService->showReservations());
    }

    #[Route('/reservations/{id}', name: 'reservations:show', methods: ['GET'])]
    public function reservationShow(int $id): Response
    {
        return $this->json($this->reservationService->showReservation($id));
    }

    #[Route('/reservations/{id}', name: 'reservations:update', methods: ['PATCH'])]
    public function reservationUpdate(int $id): Response
    {
        return $this->json([]);
    }

    #[Route('/reservations/{id}', name: 'reservations:delete', methods: ['DELETE'])]
    public function reservationDelete(int $id): Response
    {
        return $this->json($this->reservationService->deleteReservation($id));
    }

    #[Route('/resetDB', name: 'app_reset', methods: ['GET'])]
    public function reset(Maintenance $maintenance): Response
    {
        $maintenance->loadFixtures();

        return new Response('The database was reset', 200);
    }

    private function validateDays(\DateTimeImmutable $startDatetime, \DateTimeImmutable $endDatetime): array
    {
        $today = new \DateTimeImmutable('now');
        $cleanedStartDate = $startDatetime->setTime(0, 0);
        $cleanedEndDate = $endDatetime->setTime(0, 0);
        $durationInSeconds = $cleanedEndDate->getTimestamp() - $cleanedStartDate->getTimestamp();

        $moreThanSixtyDays = $today->diff($cleanedEndDate)->days >= 60;

        $errors = [];

        if ($cleanedStartDate < $today) {
            $errors[] = "Start date should be at least one day in advance";
        }

        if ($cleanedEndDate < $cleanedStartDate) {
            $errors[] = 'End date cannot be less than start date';
        }

        if ($durationInSeconds < 86400) {
            $errors[] = 'Rent should be at least 1 day';
        }

        if ($startDatetime->format('G') < 8) {
            $errors[] = "Start time should be at least 8h";
        }

        if ($endDatetime->format('G') >= 20) {
            $errors[] = "Return time should be lower than 20h";
        }

        if (true === $moreThanSixtyDays) {
            $errors[] = 'Rent should be no more then 60 days';
        }

        return $errors;
    }
}
