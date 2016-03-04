<?php

namespace DeliveryRound\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

/**
 * Class DeliveryRoundHook
 * @package DeliveryRound\Hook
 * @author Etienne Perriere <eperriere@openstudio.fr>
 */
class DeliveryRoundHook extends BaseHook
{
    public function onModuleConfig(HookRenderEvent $event)
    {
        $event->add($this->render('delivery-round-config.html'));
    }

    public function onOrderDeliveryExtra(HookRenderEvent $event)
    {
        $event->add($this->render('show-round-list.html'));
    }
}