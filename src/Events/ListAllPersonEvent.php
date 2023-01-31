<?php

namespace App\Events;

use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Contracts\EventDispatcher\Event;

class ListAllPersonEvent extends Event
{
    const LIST_ALL_PERSON_EVENT = 'person.list.all';
    public function __construct(private int $nbPerson)
    {}
    public function getNbPerson(): int{
        return $this->nbPerson;
    }
}