<?php

namespace App\Core\Entities;

class Event
{
    private $id;
    private $name;
    private $location;
    private $city;
    private $date;

    public function __construct($id, $name, $location, $city, $date)
    {
        $this->id = $id;
        $this->name = $name;
        $this->location = $location;
        $this->city = $city;
        $this->date = $date;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }
}
