<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace DeliveryRound;

use DeliveryRound\Model\DeliveryRoundQuery;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator;
use Thelia\Core\Translation\Translator;
use Thelia\Install\Database;
use Thelia\Model\AddressQuery;
use Thelia\Model\Country;
use Thelia\Model\OrderPostage;
use Thelia\Module\AbstractDeliveryModule;
use Thelia\Module\Exception\DeliveryException;

class DeliveryRound extends AbstractDeliveryModule
{
    /** @var string */
    const DOMAIN_NAME = 'deliveryround';
    const STATUS_SENT = 'sent';

    /**
     * @param ConnectionInterface|null $con
     */
    public function postActivation(ConnectionInterface $con = null): void
    {
        $database = new Database($con?->getWrappedConnection());

        $database->insertSql(null, array(__DIR__ . '/Config/TheliaMain.sql'));

        self::setConfigValue('price', 0);
    }

    /**
     * This method is called by the Delivery  loop, to check if the current module has to be displayed to the customer.
     * Override it to implements your delivery rules/
     *
     * If you return true, the delivery method will de displayed to the customer
     * If you return false, the delivery method will not be displayed
     *
     * @param Country $country the country to deliver to.
     *
     * @return boolean
     * @throws PropelException
     */
    public function isValidDelivery(Country $country): bool
    {
        // Get current addressId
        $currentAddressId = $this->getRequest()->request->get('address_id');

        if (empty($currentAddressId)) {
            if (null !== $customer = $this->getRequest()->getSession()?->getCustomerUser()) {
                $currentAddressId = AddressQuery::create()
                    ->filterByCustomer($customer)
                    ->filterByIsDefault(1)
                    ->select('ID')
                    ->findOne();
            } else {
                return false;
            }
        }

        // Get delivered zipcodes
        $deliveryRounds = DeliveryRoundQuery::create()->find();
        $deliveryRoundZipcode = [];

        /** @var Model\DeliveryRound $deliveryRound */
        foreach ($deliveryRounds as $deliveryRound) {
            $deliveryRoundZipcode[] = $deliveryRound->getZipCode();
        }

        // Check if the customer's current address is in delivered zipcodes
        return null !== AddressQuery::create()->filterByZipcode($deliveryRoundZipcode)->findOneById($currentAddressId);
    }

    /**
     * Calculate and return delivery price in the shop's default currency
     *
     * @param Country $country the country to deliver to.
     *
     * @return OrderPostage|float             the delivery price
     * @throws DeliveryException if the postage price cannot be calculated.
     * @throws PropelException
     */
    public function getPostage(Country $country): float|OrderPostage
    {
        if (! $this->isValidDelivery($country)) {
            throw new DeliveryException(
                Translator::getInstance()->trans("This module cannot be used on the current cart.")
            );
        }

        return self::getConfigValue('price', 0);
    }

    /**
     * @param ServicesConfigurator $servicesConfigurator
     * @return void
     */
    public static function configureServices(ServicesConfigurator $servicesConfigurator): void
    {
        $servicesConfigurator->load(self::getModuleCode().'\\', __DIR__)
            ->exclude([THELIA_MODULE_DIR . ucfirst(self::getModuleCode()). "/I18n/*"])
            ->autowire(true)
            ->autoconfigure(true);
    }
}
