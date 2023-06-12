<?php

namespace App\Core\Repositories;

use App\Core\Entities\Reservation;

interface ReservationRepositoryInterface
{
    public function create(Reservation $reservation): Reservation;
    public function findById(int $id): ?Reservation;
    public function sendReservationConfirmationEmail(Reservation $reservation): void;
    public function update(Reservation $reservation): Reservation;
    public function delete(Reservation $reservation): bool;
    public function findByEvent(int $eventId): array;
    public function findByUser(int $userId): array;
}
