<?php

namespace App\Core\Repositories;
use App\Mail\ReservationConfirmationMail;
use App\Models\Event;
use App\Models\Reservation as ReservationModel;
use App\Core\Entities\Reservation;
use Illuminate\Support\Facades\Mail;


class ReservationRepository implements ReservationRepositoryInterface
{
    public function create(Reservation $reservation): Reservation
    {
        $createdModel = ReservationModel::create([
            'event_id' => $reservation->getEventId(),
            'user_id' => $reservation->getUserId(),
            'ticket_count' => $reservation->getTicketCount(),
            'card_holder_info' => $reservation->getCardHolderInfo()

        ]);

        return new Reservation(
            $createdModel->id,
            $createdModel->event_id,
            $createdModel->user_id,
            $createdModel->ticket_count,
            $createdModel->card_holder_info
        );
    }


    public function update(Reservation $reservation): Reservation
    {
        $model = ReservationModel::find($reservation->getId());


        $model->event_id = $reservation->getEventId();
        $model->user_id = $reservation->getUserId();
        $model->ticket_count = $reservation->getTicketCount();
        $model->card_holder_info = $reservation->getCardHolderInfo();
        $model->save();

        return $reservation;
    }

    public function findById(int $id): ?Reservation
    {
        return ReservationModel::find($id);
    }

    public function delete($reservation): bool
    {
        return $reservation->delete();
    }

    public function findByEvent(int $eventId): array
    {
        $reservations = ReservationModel::where('event_id', $eventId)->get();

        return $reservations->toArray();
    }

    public function findByUser(int $userId): array
    {
        $reservations = ReservationModel::where('user_id', $userId)->get();

        return $reservations->toArray();
    }
    public function sendReservationConfirmationEmail(Reservation $reservation): void
    {
        $user = $reservation->getUser();

        Mail::to($user->getEmail())->send(new ReservationConfirmationMail($reservation));
    }
    public function getEventName(int $eventId): ?string
    {
        $event = Event::find($eventId);

        return $event ? $event->name : null;
    }
}
