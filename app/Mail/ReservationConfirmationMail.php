<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $eventName;

    public function __construct(string $eventName)
    {
        $this->eventName = $eventName;
    }

    public function build()
    {
        return $this->view('emails.reservation_confirmation')
            ->subject('Reservation Confirmation')
            ->with([
                'eventName' => $this->eventName,
            ]);
    }
}
