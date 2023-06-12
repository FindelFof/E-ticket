<?php

namespace App\Core\Repositories;

use App\Core\Entities\Reservation;
use App\Mail\ReservationConfirmationMail;
use Illuminate\Support\Facades\Mail;

class EmailSenderRepository implements EmailSenderInterface
{
    public function sendReservationConfirmationEmail(Reservation $reservation): void
    {
        $user = $reservation->getUser();
        $eventName = $reservation->getEventName();
        $email = $user->getEmail();

        $data = [
            'reservation' => $reservation,
            'eventName' => $eventName,
        ];

        Mail::to($email)->send(new ReservationConfirmationMail($data));
    }
}
