<?php

namespace App\EventSubscriber;

use App\Events\AddPersonEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PersonEventSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [AddPersonEvent::ADD_PERSON_EVENT => ['onAddPersonEvent', 3000]];
        // TODO: Implement getSubscribedEvents() method.
    }

    public function onAddPersonEvent(AddPersonEvent $event){
        //send confirmation mail to the user

    }
}