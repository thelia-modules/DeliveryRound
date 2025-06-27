<?php
/*************************************************************************************/
/*                                                                                   */
/*      Thelia	                                                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : info@thelia.net                                                      */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      This program is free software; you can redistribute it and/or modify         */
/*      it under the terms of the GNU General Public License as published by         */
/*      the Free Software Foundation; either version 3 of the License                */
/*                                                                                   */
/*      This program is distributed in the hope that it will be useful,              */
/*      but WITHOUT ANY WARRANTY; without even the implied warranty of               */
/*      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                */
/*      GNU General Public License for more details.                                 */
/*                                                                                   */
/*      You should have received a copy of the GNU General Public License            */
/*	    along with this program. If not, see <http://www.gnu.org/licenses/>.         */
/*                                                                                   */
/*************************************************************************************/

namespace DeliveryRound\EventListeners;

use DeliveryRound\DeliveryRound;
use Exception;
use Propel\Runtime\Exception\PropelException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Action\BaseAction;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Mailer\MailerFactory;
use Thelia\Model\ConfigQuery;
use Thelia\Model\OrderStatusQuery;

/**
 * Class SendEMail
 * @package DeliveryRound\EventListeners
 * @author Etienne Perriere <eperriere@openstudio.fr>
 */
class SendEMail extends BaseAction implements EventSubscriberInterface
{
    public function __construct(private readonly MailerFactory $mailerFactory)
    {
    }

    /**
     * @throws PropelException
     * @throws Exception
     */
    public function update_status(OrderEvent $event): void
    {
        if ($event->getOrder()->getDeliveryModuleId() === DeliveryRound::getModuleId()) {
            $targetStatusId = OrderStatusQuery::create()
                ->filterById(4)
                ->findOne()
                ?->getId();

            if ($event->getOrder()->getStatusId() === $targetStatusId) {
                $order = $event->getOrder();

                $contact_email = ConfigQuery::read('store_email', false);
                $store_name = ConfigQuery::read('store_name');

                if (!$contact_email || !$store_name) {
                    throw new Exception("Store email or store name is not configured in the settings.");
                }

                $customer = $order->getCustomer();

                $messageParameters = [
                    "order_id" => $order->getId(),
                    "order_ref" => $order->getRef(),
                    "order_date" => $order->getCreatedAt(),
                    "update_date" => $order->getUpdatedAt()
                ];

                $this->mailerFactory->sendEmailMessage(
                    'order_confirmation_deliveryround',
                    [$contact_email => $store_name],
                    [$customer->getEmail() => $customer->getFirstname() . " " . $customer->getLastname()],
                    $messageParameters,
                    $order->getLang()->getLocale()
                );
            }
        }
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents(): array
    {
        return array(
            TheliaEvents::ORDER_UPDATE_STATUS => array("update_status", 128)
        );
    }
}
