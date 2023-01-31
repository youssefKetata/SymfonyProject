<?php

namespace App\EventListener;

use App\Events\AddPersonEvent;
use App\Events\ListAllPersonEvent;
use App\Events\LoginEvent;
use Psr\Log\LoggerInterface;

class PersonListener
{

    public function __construct(private LoggerInterface $logger)
    {
    }

    public function onPersonAdd(AddPersonEvent $event): void
    {
        $this->logger->debug("I'm listening to person.add event. ".$event->getPerson()->getName()." is added");
    }

    public function onListAllPerson(ListAllPersonEvent $event): void
    {
        $this->logger->debug("there are ". $event->getNbPerson()." persons in database");
    }

    public function onUserLogin(LoginEvent $event): string
    {
        return $event->getUser()->getEmail(). " Logged in with ".implode($event->getUser()->getRoles());
    }

}