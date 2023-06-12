<?php

namespace App\Core\Repositories;

use App\Core\Entities\Event;

interface EventRepositoryInterface
{
    public function findById($id);

    public function findAll();

    public function findByLocation($location);

    public function findByCity($city);

    public function searchByCityAndDate($city,$date);

    public function save(Event $event);

    public function delete(Event $event);
}
