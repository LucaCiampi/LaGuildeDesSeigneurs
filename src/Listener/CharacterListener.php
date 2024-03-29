<?php

namespace App\Listener;

use App\Event\CharacterEvent;
use DateTime;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CharacterListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            CharacterEvent::CHARACTER_CREATED => 'characterCreated',
        );
    }

    public function characterCreated($event)
    {
        $character = $event->getCharacter();

        $character->setIntelligence(250);

        $dateBegin = new DateTime('22-11-2021');
        $dateEnd = new DateTime('30-11-2022');
        $dateToday = new DateTime();
        if ($dateToday > $dateBegin && $dateToday < $dateEnd) {
            $character->setLife(20);
        }
    }
}