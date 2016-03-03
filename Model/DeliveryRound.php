<?php

namespace DeliveryRound\Model;

use DeliveryRound\Model\Base\DeliveryRound as BaseDeliveryRound;
use DeliveryRound\Model\Map\DeliveryRoundTableMap;
use Propel\Runtime\Exception\PropelException;

class DeliveryRound extends BaseDeliveryRound
{
    /**
     * Set the value of [day] column.
     *
     * @param      int $v new value
     * @return   \DeliveryRound\Model\DeliveryRound The current object (for fluent API support)
     * @throws PropelException
     */
    public function setDay($v)
    {
        if ($v !== null && !is_numeric($v)) {
            $valueSet = DeliveryRoundTableMap::getValueSet(DeliveryRoundTableMap::DAY);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->day !== $v) {
            $this->day = $v;
            $this->modifiedColumns[DeliveryRoundTableMap::DAY] = true;
        }

        return $this;
    } // setDay()
}
