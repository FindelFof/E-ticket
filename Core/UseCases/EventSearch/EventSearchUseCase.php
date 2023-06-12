<?php

namespace App\Core\UseCases\EventSearch;

use App\Core\Repositories\EventRepositoryInterface;

class EventSearchUseCase
{
    private EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function findAll()
    {
        return $this->eventRepository->findAll();
    }

    public function findById($id)
    {
        return $this->eventRepository->findById($id);
    }

    public function searchByCity($city)
    {
        return $this->eventRepository->findByCity($city);
    }

    public function searchByLocation($location)
    {
        return $this->eventRepository->findByLocation($location);
    }

    public function searchByCityAndDate($city, $date)
    {
        return $this->eventRepository->searchByCityAndDate($city, $date);
    }
}
