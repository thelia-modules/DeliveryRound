<?php

namespace DeliveryRound\Loop;

use DeliveryRound\Model\DeliveryRoundQuery;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
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
        return new ArgumentCollection();
    }

    /**
     * this method returns a Propel ModelCriteria
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function buildModelCriteria()
    {
        $search = DeliveryRoundQuery::create();
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
            $loopResultRow->set('PRESENCE_TIME', $deliveryRound->getPresenceTime());
            $loopResultRow->set('PRICE', $deliveryRound->getPrice());

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }
}