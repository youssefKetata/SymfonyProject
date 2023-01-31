<?php

namespace App\Events;

use App\Entity\Person;
use Symfony\Contracts\EventDispatcher\Event;

class AddPersonEvent extends Event
{
    const ADD_PERSON_EVENT = 'person.add';
    public function __construct(private Person $person)
    {
    }

    public function getPerson(): Person
    {
        return $this->person;
    }

}