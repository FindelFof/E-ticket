<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'date',
        'city',
        'location',
        'price',
        'cardholderinfo'
    ];
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function getEventName(): string
    {
        $event = Event::find($this->eventId);

        return $event ? $event->name : '';
    }

    public function getEmail(): string
    {
        $user = User::find($this->userId);

        return $user ? $user->email : '';
    }
}
