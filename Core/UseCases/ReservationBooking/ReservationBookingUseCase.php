<?php

namespace App\Core\UseCases\ReservationBooking;

use App\Core\Entities\Reservation;
use App\Core\Repositories\EmailSenderInterface;
use App\Core\Repositories\ReservationRepositoryInterface;

class ReservationBookingUseCase
{
    private ReservationRepositoryInterface $reservationRepository;
    private EmailSenderInterface $emailSender;

    public function __construct(ReservationRepositoryInterface $reservationRepository, EmailSenderInterface $emailSender)
    {
        $this->reservationRepository = $reservationRepository;
        $this->emailSender = $emailSender;
    }

    public function bookReservation($id, int $eventId, int $userId, int $ticketCount, string $cardHolderInfo): Reservation
    {

        $reservation = new Reservation($id, $eventId, $userId, $ticketCount, $cardHolderInfo);

        $createdReservation = $this->reservationRepository->create($reservation);

        $this->sendReservationConfirmationEmail($createdReservation);

        return $createdReservation;
    }


    public function cancelReservation(int $reservationId): bool
    {

        $reservation = $this->reservationRepository->findById($reservationId);

        return $this->reservationRepository->delete($reservation);
    }
    private function sendReservationConfirmationEmail(Reservation $reservation): void
    {
        $user = $reservation->getUser();

        $this->emailSender->sendReservationConfirmationEmail($reservation);
    }
}
