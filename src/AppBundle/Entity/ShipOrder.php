<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Person;

/**
 * @ORM\Entity
 * @ORM\Table(name="shiporder")
 */
class ShipOrder
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $orderid;


    /**
     * One Product has One Shipping.
     * @ORM\OneToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="personid")
     */
    private $orderperson;

    /**
     * @ORM\Column(type="array")
     */
    private $shipto;

    /**
     * @ORM\Column(type="array")
     */
    private $items;

    // Getters
    public function getOrderId()
    {
        return $this->orderid;
    }

    public function getOrderPerson()
    {
        return $this->orderperson;
    }

    public function getShipTo()
    {
        return $this->shipto;
    }

    public function getItems()
    {
        return $this->items;
    }

    // Setters
    public function setOrderId($orderid)
    {
        $this->orderid = $orderid;
    }

    public function setOrderPerson($orderperson)
    {
        $this->orderperson = $orderperson;
    }

    public function setShipTo($shipto)
    {
        $this->shipto = $shipto;
    }

    public function setItems($items)
    {
        $this->items = $items;
    }
}