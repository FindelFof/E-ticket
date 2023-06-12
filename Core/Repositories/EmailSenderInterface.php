<?php
namespace App\Core\Repositories;

use App\Core\Entities\Reservation;

interface EmailSenderInterface
{
    public function sendReservationConfirmationEmail(Reservation $reservation): void;
}
