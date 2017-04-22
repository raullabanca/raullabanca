<?php

namespace AppBundle\Entity;

class UploadObject
{
    private $person;
    private $shiporder;

    public function getPerson()
    {
        return $this->person;
    }

    public function setPerson($person)
    {
        $this->person = $person;
    }

    public function getShipOrder()
    {
        return $this->shiporder;
    }

    public function setShipOrder($shiporder)
    {
        $this->shiporder = $shiporder;
    }
}