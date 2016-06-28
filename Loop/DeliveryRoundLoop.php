<?php

namespace DeliveryRound\Loop;

use DeliveryRound\Model\DeliveryRoundQuery;
use DeliveryRound\Model\Map\DeliveryRoundTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

/**
 * Class DeliveryRoundLoop
 * @package DeliveryRound\Loop
 * @author Etienne Perriere <eperriere@openstudio.fr>
 */
class DeliveryRoundLoop extends BaseLoop implements PropelSearchLoopInterface
{
    /**
     * Definition of loop arguments
     *
     * @return \Thelia\Core\Template\Loop\Argument\ArgumentCollection
     */
    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntListTypeArgument('id'),
            Argument::createAnyListTypeArgument('zipcode'),
            Argument::createAnyListTypeArgument('city'),
            Argument::createEnumListTypeArgument('day', DeliveryRoundTableMap::getValueSet(DeliveryRoundTableMap::DAY)),
            Argument::createEnumListTypeArgument('order', [
                'day',
                'day-reverse',
                'city',
                'city-reverse',
                'zipcode',
                'zipcode-reverse'
            ], 'day')
        );
    }

    /**
     * this method returns a Propel ModelCriteria
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function buildModelCriteria()
    {
        $search = DeliveryRoundQuery::create();

        if ($this->getId() !== null) {
            $search->filterById($this->getId(), Criteria::IN);
        }

        if ($this->getZipcode() !== null) {
            $search->filterByZipCode($this->getZipcode(), Criteria::IN);
        }
        if ($this->getCity() !== null) {
            $search->filterByCity($this->getCity(), Criteria::IN);
        }

        if ($this->getDay() !== null) {
            $search->filterByDay($this->getDay(), Criteria::IN);
        }

        foreach ($this->getOrder() as $order) {
            switch ($order) {
                case 'day':
                    $search->orderByDay();
                    break;
                case 'day-reverse':
                    $search->orderByDay(Criteria::DESC);
                    break;
                case 'city':
                    $search->orderByCity();
                    break;
                case 'city-reverse':
                    $search->orderByCity(Criteria::DESC);
                    break;
                case 'zipcode':
                    $search->orderByZipCode();
                    break;
                case 'zipcode-reverse':
                    $search->orderByZipCode(Criteria::DESC);
                    break;
            }
        }

        return $search;
    }

    /**
     * @param LoopResult $loopResult
     *
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult)
    {
        /** @var \DeliveryRound\Model\DeliveryRound $deliveryRound */
        foreach ($loopResult->getResultDataCollection() as $deliveryRound) {
            $loopResultRow = new LoopResultRow($deliveryRound);

            $loopResultRow->set('ID', $deliveryRound->getId());
            $loopResultRow->set('ZIPCODE', $deliveryRound->getZipCode());
            $loopResultRow->set('CITY', $deliveryRound->getCity());
            $loopResultRow->set('ADDRESS', $deliveryRound->getAddress());
            $loopResultRow->set('DAY', $deliveryRound->getDay());
            $loopResultRow->set('DELIVERY_PERIOD', $deliveryRound->getDeliveryPeriod());

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }
}
