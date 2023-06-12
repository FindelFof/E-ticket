<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;


    protected ?int $id = null;
    protected ?int $event_id = null;
    protected ?int $user_id = null;
    protected ?int $ticket_count = null;
    protected ?string $card_holder_info = null;
    // ...
    protected $fillable = [
        'event_id',
        'user_id',
        'ticket_count',
        'card_holder_info'
    ];
    // Relation avec l'événement
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
