<?php

namespace DeliveryRound\Model\Base;

use \Exception;
use \PDO;
use DeliveryRound\Model\DeliveryRound as ChildDeliveryRound;
use DeliveryRound\Model\DeliveryRoundQuery as ChildDeliveryRoundQuery;
use DeliveryRound\Model\Map\DeliveryRoundTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'delivery_round' table.
 *
 *
 *
 * @method     ChildDeliveryRoundQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildDeliveryRoundQuery orderByZipCode($order = Criteria::ASC) Order by the zip_code column
 * @method     ChildDeliveryRoundQuery orderByCity($order = Criteria::ASC) Order by the city column
 * @method     ChildDeliveryRoundQuery orderByAddress($order = Criteria::ASC) Order by the address column
 * @method     ChildDeliveryRoundQuery orderByDay($order = Criteria::ASC) Order by the day column
 * @method     ChildDeliveryRoundQuery orderByPresenceTime($order = Criteria::ASC) Order by the presence_time column
 * @method     ChildDeliveryRoundQuery orderByPrice($order = Criteria::ASC) Order by the price column
 *
 * @method     ChildDeliveryRoundQuery groupById() Group by the id column
 * @method     ChildDeliveryRoundQuery groupByZipCode() Group by the zip_code column
 * @method     ChildDeliveryRoundQuery groupByCity() Group by the city column
 * @method     ChildDeliveryRoundQuery groupByAddress() Group by the address column
 * @method     ChildDeliveryRoundQuery groupByDay() Group by the day column
 * @method     ChildDeliveryRoundQuery groupByPresenceTime() Group by the presence_time column
 * @method     ChildDeliveryRoundQuery groupByPrice() Group by the price column
 *
 * @method     ChildDeliveryRoundQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDeliveryRoundQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDeliveryRoundQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDeliveryRound findOne(ConnectionInterface $con = null) Return the first ChildDeliveryRound matching the query
 * @method     ChildDeliveryRound findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDeliveryRound matching the query, or a new ChildDeliveryRound object populated from the query conditions when no match is found
 *
 * @method     ChildDeliveryRound findOneById(int $id) Return the first ChildDeliveryRound filtered by the id column
 * @method     ChildDeliveryRound findOneByZipCode(string $zip_code) Return the first ChildDeliveryRound filtered by the zip_code column
 * @method     ChildDeliveryRound findOneByCity(string $city) Return the first ChildDeliveryRound filtered by the city column
 * @method     ChildDeliveryRound findOneByAddress(string $address) Return the first ChildDeliveryRound filtered by the address column
 * @method     ChildDeliveryRound findOneByDay(int $day) Return the first ChildDeliveryRound filtered by the day column
 * @method     ChildDeliveryRound findOneByPresenceTime(string $presence_time) Return the first ChildDeliveryRound filtered by the presence_time column
 * @method     ChildDeliveryRound findOneByPrice(string $price) Return the first ChildDeliveryRound filtered by the price column
 *
 * @method     array findById(int $id) Return ChildDeliveryRound objects filtered by the id column
 * @method     array findByZipCode(string $zip_code) Return ChildDeliveryRound objects filtered by the zip_code column
 * @method     array findByCity(string $city) Return ChildDeliveryRound objects filtered by the city column
 * @method     array findByAddress(string $address) Return ChildDeliveryRound objects filtered by the address column
 * @method     array findByDay(int $day) Return ChildDeliveryRound objects filtered by the day column
 * @method     array findByPresenceTime(string $presence_time) Return ChildDeliveryRound objects filtered by the presence_time column
 * @method     array findByPrice(string $price) Return ChildDeliveryRound objects filtered by the price column
 *
 */
abstract class DeliveryRoundQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \DeliveryRound\Model\Base\DeliveryRoundQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\DeliveryRound\\Model\\DeliveryRound', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDeliveryRoundQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDeliveryRoundQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \DeliveryRound\Model\DeliveryRoundQuery) {
            return $criteria;
        }
        $query = new \DeliveryRound\Model\DeliveryRoundQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildDeliveryRound|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = DeliveryRoundTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DeliveryRoundTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildDeliveryRound A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, ZIP_CODE, CITY, ADDRESS, DAY, PRESENCE_TIME, PRICE FROM delivery_round WHERE ID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildDeliveryRound();
            $obj->hydrate($row);
            DeliveryRoundTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildDeliveryRound|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildDeliveryRoundQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DeliveryRoundTableMap::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildDeliveryRoundQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DeliveryRoundTableMap::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDeliveryRoundQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(DeliveryRoundTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(DeliveryRoundTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DeliveryRoundTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the zip_code column
     *
     * Example usage:
     * <code>
     * $query->filterByZipCode('fooValue');   // WHERE zip_code = 'fooValue'
     * $query->filterByZipCode('%fooValue%'); // WHERE zip_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $zipCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDeliveryRoundQuery The current query, for fluid interface
     */
    public function filterByZipCode($zipCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($zipCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $zipCode)) {
                $zipCode = str_replace('*', '%', $zipCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DeliveryRoundTableMap::ZIP_CODE, $zipCode, $comparison);
    }

    /**
     * Filter the query on the city column
     *
     * Example usage:
     * <code>
     * $query->filterByCity('fooValue');   // WHERE city = 'fooValue'
     * $query->filterByCity('%fooValue%'); // WHERE city LIKE '%fooValue%'
     * </code>
     *
     * @param     string $city The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDeliveryRoundQuery The current query, for fluid interface
     */
    public function filterByCity($city = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($city)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $city)) {
                $city = str_replace('*', '%', $city);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DeliveryRoundTableMap::CITY, $city, $comparison);
    }

    /**
     * Filter the query on the address column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress('fooValue');   // WHERE address = 'fooValue'
     * $query->filterByAddress('%fooValue%'); // WHERE address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $address The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDeliveryRoundQuery The current query, for fluid interface
     */
    public function filterByAddress($address = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($address)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $address)) {
                $address = str_replace('*', '%', $address);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DeliveryRoundTableMap::ADDRESS, $address, $comparison);
    }

    /**
     * Filter the query on the day column
     *
     * @param     mixed $day The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDeliveryRoundQuery The current query, for fluid interface
     */
    public function filterByDay($day = null, $comparison = null)
    {
        $valueSet = DeliveryRoundTableMap::getValueSet(DeliveryRoundTableMap::DAY);
        if (is_scalar($day)) {
            if (!in_array($day, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $day));
            }
            $day = array_search($day, $valueSet);
        } elseif (is_array($day)) {
            $convertedValues = array();
            foreach ($day as $value) {
                if (!in_array($value, $valueSet)) {
                    throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $value));
                }
                $convertedValues []= array_search($value, $valueSet);
            }
            $day = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DeliveryRoundTableMap::DAY, $day, $comparison);
    }

    /**
     * Filter the query on the presence_time column
     *
     * Example usage:
     * <code>
     * $query->filterByPresenceTime('fooValue');   // WHERE presence_time = 'fooValue'
     * $query->filterByPresenceTime('%fooValue%'); // WHERE presence_time LIKE '%fooValue%'
     * </code>
     *
     * @param     string $presenceTime The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDeliveryRoundQuery The current query, for fluid interface
     */
    public function filterByPresenceTime($presenceTime = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($presenceTime)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $presenceTime)) {
                $presenceTime = str_replace('*', '%', $presenceTime);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DeliveryRoundTableMap::PRESENCE_TIME, $presenceTime, $comparison);
    }

    /**
     * Filter the query on the price column
     *
     * Example usage:
     * <code>
     * $query->filterByPrice(1234); // WHERE price = 1234
     * $query->filterByPrice(array(12, 34)); // WHERE price IN (12, 34)
     * $query->filterByPrice(array('min' => 12)); // WHERE price > 12
     * </code>
     *
     * @param     mixed $price The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDeliveryRoundQuery The current query, for fluid interface
     */
    public function filterByPrice($price = null, $comparison = null)
    {
        if (is_array($price)) {
            $useMinMax = false;
            if (isset($price['min'])) {
                $this->addUsingAlias(DeliveryRoundTableMap::PRICE, $price['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($price['max'])) {
                $this->addUsingAlias(DeliveryRoundTableMap::PRICE, $price['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DeliveryRoundTableMap::PRICE, $price, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDeliveryRound $deliveryRound Object to remove from the list of results
     *
     * @return ChildDeliveryRoundQuery The current query, for fluid interface
     */
    public function prune($deliveryRound = null)
    {
        if ($deliveryRound) {
            $this->addUsingAlias(DeliveryRoundTableMap::ID, $deliveryRound->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the delivery_round table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DeliveryRoundTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DeliveryRoundTableMap::clearInstancePool();
            DeliveryRoundTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildDeliveryRound or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildDeliveryRound object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DeliveryRoundTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DeliveryRoundTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        DeliveryRoundTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DeliveryRoundTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // DeliveryRoundQuery
