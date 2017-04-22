<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="person")
 */
class Person
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $personid;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $personname;

    /**
     * @ORM\Column(type="array")
     */
    private $phones;
    
     // Getters
    public function getPersonId()
    {
        return $this->personid;
    }

    public function getPersonName()
    {
        return $this->personname;
    }

    public function getPhones()
    {
        return $this->phones;
    }

    // Setters
    public function setPersonId($personid)
    {
        $this->personid = $personid;
    }

    public function setPersonName($personname)
    {
        $this->personname = $personname;
    }

    public function setPhones($phones)
    {
        $this->phones = $phones;
    }

}