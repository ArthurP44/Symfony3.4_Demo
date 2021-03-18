<?php

namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProductPublishedSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            ProductPublishedEvent::NAME => 'onProductPublished'
        ];
    }

    public function onProductPublished(ProductPublishedEvent $event)
    {
        if ($event->getProduct()->getName() === 'test'){
            echo 'test is not a proper name, you can do better !';
        } else {
            echo 'your product ' .$event->getProduct()->getName(). ' was successfully registered';
        }
    }
}