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

    /**
     * @param ConnectionInterface|null $con
     */
    public function postActivation(ConnectionInterface $con = null)
    {
        $database = new Database($con->getWrappedConnection());

        $database->insertSql(null, array(__DIR__ . '/Config/insert.sql'));

        DeliveryRound::setConfigValue('price', 0);
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
     */
    public function isValidDelivery(Country $country)
    {
        // Get current customer & addressId
        $customer = $this->getRequest()->getSession()->getCustomerUser();
        $currentAddressId = $this->getCurrentlySelectedAddress($this->getRequest(), $customer);

        // Get delivered zipcodes
        $deliveryRounds = DeliveryRoundQuery::create()->find();
        $deliveryRoundZipcode = [];

        /** @var \DeliveryRound\Model\DeliveryRound $deliveryRound */
        foreach ($deliveryRounds as $deliveryRound) {
            $deliveryRoundZipcode[] = $deliveryRound->getZipCode();
        }

        // Check if the customer's current address is deliverable
        if (null !== AddressQuery::create()->filterByZipcode($deliveryRoundZipcode)->findOneById($currentAddressId)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param \Thelia\Core\HttpFoundation\Request $request
     * @param \Thelia\Model\Customer $customer
     * @return array|mixed|\Propel\Runtime\Collection\ObjectCollection
     * @throws \Propel\Runtime\Exception\PropelException
     */
    protected function getCurrentlySelectedAddress($request, $customer)
    {
        if (empty($request->request->get('address_id'))) {
            $currentAddressId = AddressQuery::create()
                ->filterByCustomer($customer)
                ->filterByIsDefault(1)
                ->select('ID')
                ->findOne();
        } else {
            $currentAddressId = $request->request->get('address_id');
        }

        return $currentAddressId;
    }

    /**
     * Calculate and return delivery price in the shop's default currency
     *
     * @param Country $country the country to deliver to.
     *
     * @return OrderPostage|float             the delivery price
     * @throws DeliveryException if the postage price cannot be calculated.
     */
    public function getPostage(Country $country)
    {
        if (! $this->isValidDelivery($country)) {
            throw new DeliveryException(
                Translator::getInstance()->trans("This module cannot be used on the current cart.")
            );
        }

        return $this->getConfigValue('price', 0);
    }
}
