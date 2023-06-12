<?php

namespace App\Core\Repositories;

use App\Models\Event;

class EventRepository implements EventRepositoryInterface
{
    public function findById($id)
    {
        return Event::find($id);
    }

    public function findAll()
    {
        return Event::orderBy('date', 'desc')->get();
    }

    public function findByLocation($location)
    {
        return Event::where('location', $location)->get();
    }
    public function findByCity($city)
    {
        return Event::where('city', $city)->get();
    }


    public function save($event)
    {
        // Logic to save an event
    }

    public function delete($event)
    {
        $model = Event::find($event->getId());
        if ($model) {
            $model->delete();
        }
    }

    public function searchByCityAndDate($city, $date)
    {
        return Event::where('city', $city)->where('date', $date)->get();
    }

}
