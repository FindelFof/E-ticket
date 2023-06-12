<?php

namespace App\Core\Entities;

use App\Http\Controllers\Controller;

class Reservation extends Controller
{
    private $id;
    private $eventId;
    private $userId;
    private $ticketCount;
    private $cardHolderInfo;
    private $email;

    public function __construct($id, $eventId, $userId, $ticketCount, $cardHolderInfo)
    {
        $this->id = $id;
        $this->eventId = $eventId;
        $this->userId = $userId;
        $this->ticketCount = $ticketCount;
        $this->cardHolderInfo = $cardHolderInfo;
    }

    // Getters and setters...

    public function getId()
    {
        return $this->id;
    }

    public function getEventId()
    {
        return $this->eventId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getTicketCount()
    {
        return $this->ticketCount;
    }

    public function getCardHolderInfo()
    {
        return $this->cardHolderInfo;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function setEventId($eventId)
    {
        $this->eventId = $eventId;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTicketCount($ticketCount)
    {
        $this->ticketCount = $ticketCount;
    }

    public function setCardHolderInfo($cardHolderInfo)
    {
        $this->cardHolderInfo = $cardHolderInfo;
    }

    public function getUser()
    {
        return auth()->user();
    }

    public function getEmail(): string
    {
        $user = auth()->user();

        if ($user) {
            return $user->email;
        }

        return '';
    }
}
