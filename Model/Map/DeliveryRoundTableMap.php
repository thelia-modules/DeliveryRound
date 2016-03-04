<?php

namespace DeliveryRound\Model\Map;

use DeliveryRound\Model\DeliveryRound;
use DeliveryRound\Model\DeliveryRoundQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'delivery_round' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class DeliveryRoundTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'DeliveryRound.Model.Map.DeliveryRoundTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'delivery_round';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\DeliveryRound\\Model\\DeliveryRound';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'DeliveryRound.Model.DeliveryRound';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the ID field
     */
    const ID = 'delivery_round.ID';

    /**
     * the column name for the ZIP_CODE field
     */
    const ZIP_CODE = 'delivery_round.ZIP_CODE';

    /**
     * the column name for the CITY field
     */
    const CITY = 'delivery_round.CITY';

    /**
     * the column name for the ADDRESS field
     */
    const ADDRESS = 'delivery_round.ADDRESS';

    /**
     * the column name for the DAY field
     */
    const DAY = 'delivery_round.DAY';

    /**
     * the column name for the DELIVERY_PERIOD field
     */
    const DELIVERY_PERIOD = 'delivery_round.DELIVERY_PERIOD';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /** The enumerated values for the DAY field */
    const DAY_MONDAY = 'monday';
    const DAY_TUESDAY = 'tuesday';
    const DAY_WEDNESDAY = 'wednesday';
    const DAY_THURSDAY = 'thursday';
    const DAY_FRIDAY = 'friday';
    const DAY_SATURDAY = 'saturday';
    const DAY_SUNDAY = 'sunday';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'ZipCode', 'City', 'Address', 'Day', 'DeliveryPeriod', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'zipCode', 'city', 'address', 'day', 'deliveryPeriod', ),
        self::TYPE_COLNAME       => array(DeliveryRoundTableMap::ID, DeliveryRoundTableMap::ZIP_CODE, DeliveryRoundTableMap::CITY, DeliveryRoundTableMap::ADDRESS, DeliveryRoundTableMap::DAY, DeliveryRoundTableMap::DELIVERY_PERIOD, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'ZIP_CODE', 'CITY', 'ADDRESS', 'DAY', 'DELIVERY_PERIOD', ),
        self::TYPE_FIELDNAME     => array('id', 'zip_code', 'city', 'address', 'day', 'delivery_period', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'ZipCode' => 1, 'City' => 2, 'Address' => 3, 'Day' => 4, 'DeliveryPeriod' => 5, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'zipCode' => 1, 'city' => 2, 'address' => 3, 'day' => 4, 'deliveryPeriod' => 5, ),
        self::TYPE_COLNAME       => array(DeliveryRoundTableMap::ID => 0, DeliveryRoundTableMap::ZIP_CODE => 1, DeliveryRoundTableMap::CITY => 2, DeliveryRoundTableMap::ADDRESS => 3, DeliveryRoundTableMap::DAY => 4, DeliveryRoundTableMap::DELIVERY_PERIOD => 5, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'ZIP_CODE' => 1, 'CITY' => 2, 'ADDRESS' => 3, 'DAY' => 4, 'DELIVERY_PERIOD' => 5, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'zip_code' => 1, 'city' => 2, 'address' => 3, 'day' => 4, 'delivery_period' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
                DeliveryRoundTableMap::DAY => array(
                            self::DAY_MONDAY,
            self::DAY_TUESDAY,
            self::DAY_WEDNESDAY,
            self::DAY_THURSDAY,
            self::DAY_FRIDAY,
            self::DAY_SATURDAY,
            self::DAY_SUNDAY,
        ),
    );

    /**
     * Gets the list of values for all ENUM columns
     * @return array
     */
    public static function getValueSets()
    {
      return static::$enumValueSets;
    }

    /**
     * Gets the list of values for an ENUM column
     * @param string $colname
     * @return array list of possible values for the column
     */
    public static function getValueSet($colname)
    {
        $valueSets = self::getValueSets();

        return $valueSets[$colname];
    }

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('delivery_round');
        $this->setPhpName('DeliveryRound');
        $this->setClassName('\\DeliveryRound\\Model\\DeliveryRound');
        $this->setPackage('DeliveryRound.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('ZIP_CODE', 'ZipCode', 'VARCHAR', true, 20, null);
        $this->addColumn('CITY', 'City', 'VARCHAR', true, 255, null);
        $this->addColumn('ADDRESS', 'Address', 'LONGVARCHAR', false, null, null);
        $this->addColumn('DAY', 'Day', 'ENUM', true, null, null);
        $this->getColumn('DAY', false)->setValueSet(array (
  0 => 'monday',
  1 => 'tuesday',
  2 => 'wednesday',
  3 => 'thursday',
  4 => 'friday',
  5 => 'saturday',
  6 => 'sunday',
));
        $this->addColumn('DELIVERY_PERIOD', 'DeliveryPeriod', 'LONGVARCHAR', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {

            return (int) $row[
                            $indexType == TableMap::TYPE_NUM
                            ? 0 + $offset
                            : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
                        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? DeliveryRoundTableMap::CLASS_DEFAULT : DeliveryRoundTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     * @return array (DeliveryRound object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = DeliveryRoundTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = DeliveryRoundTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + DeliveryRoundTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = DeliveryRoundTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            DeliveryRoundTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = DeliveryRoundTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = DeliveryRoundTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                DeliveryRoundTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(DeliveryRoundTableMap::ID);
            $criteria->addSelectColumn(DeliveryRoundTableMap::ZIP_CODE);
            $criteria->addSelectColumn(DeliveryRoundTableMap::CITY);
            $criteria->addSelectColumn(DeliveryRoundTableMap::ADDRESS);
            $criteria->addSelectColumn(DeliveryRoundTableMap::DAY);
            $criteria->addSelectColumn(DeliveryRoundTableMap::DELIVERY_PERIOD);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.ZIP_CODE');
            $criteria->addSelectColumn($alias . '.CITY');
            $criteria->addSelectColumn($alias . '.ADDRESS');
            $criteria->addSelectColumn($alias . '.DAY');
            $criteria->addSelectColumn($alias . '.DELIVERY_PERIOD');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(DeliveryRoundTableMap::DATABASE_NAME)->getTable(DeliveryRoundTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(DeliveryRoundTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(DeliveryRoundTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new DeliveryRoundTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a DeliveryRound or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or DeliveryRound object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DeliveryRoundTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \DeliveryRound\Model\DeliveryRound) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(DeliveryRoundTableMap::DATABASE_NAME);
            $criteria->add(DeliveryRoundTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = DeliveryRoundQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { DeliveryRoundTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { DeliveryRoundTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the delivery_round table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return DeliveryRoundQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a DeliveryRound or Criteria object.
     *
     * @param mixed               $criteria Criteria or DeliveryRound object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DeliveryRoundTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from DeliveryRound object
        }

        if ($criteria->containsKey(DeliveryRoundTableMap::ID) && $criteria->keyContainsValue(DeliveryRoundTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.DeliveryRoundTableMap::ID.')');
        }


        // Set the correct dbName
        $query = DeliveryRoundQuery::create()->mergeWith($criteria);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = $query->doInsert($con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

} // DeliveryRoundTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
DeliveryRoundTableMap::buildTableMap();
