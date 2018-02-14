<?php
/**
 * @author      Matters Studio (https://matters.tech)
 */

namespace Matters;

use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\Sql\Literal;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Hydrator\HydratorInterface;

/**
 * Class Repository
 * @package Matters
 */
abstract class Repository
{
    const COUNT_COLUMN = 'count';

    /**
     * @var TableGateway
     */
    protected $tableGateway;

    /**
     * CreditCard constructor.
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @return \Zend\Db\Sql\Select
     */
    protected function select() : Select
    {
        return new Select($this->tableGateway->getTable());
    }

    /**
     * @return \Zend\Db\Sql\Select
     */
    protected function count() : Select
    {
        return $this->select()->columns([
            self::COUNT_COLUMN => new Literal('COUNT(1)')
        ]);
    }

    /**
     * Return the id of the last row inserted in the current table
     * @return int
     */
    protected function getLastIdInserted()
    {
        return $this->tableGateway->getAdapter()->getDriver()->getLastGeneratedValue(
            $this->tableGateway->getTable() . '_id_seq'
        );
    }

    /**
     * @return \Zend\Hydrator\HydratorInterface
     */
    protected function getHydrator() : HydratorInterface
    {
        return $this->tableGateway->getResultSetPrototype()->getHydrator();
    }

    protected function beginTransaction()
    {
        return $this->tableGateway->getAdapter()->getDriver()->getConnection()->beginTransaction();
    }

    protected function rollback()
    {
        return $this->tableGateway->getAdapter()->getDriver()->getConnection()->rollback();
    }

    protected function commit()
    {
        return $this->tableGateway->getAdapter()->getDriver()->getConnection()->commit();
    }

    /**
     * @param \Zend\Db\Sql\Select $select
     * @return null|object
     */
    protected function fetchOneEntity(Select $select)
    {
        /** @var HydratingResultSet $result */
        $result = $this->tableGateway->selectWith($select);
        return count($result) > 0 ? $result->current() : null;
    }

    /**
     * @param \Zend\Db\Sql\Select $select
     * @return \Zend\Db\ResultSet\ResultSetInterface
     */
    protected function fetchListEntities(Select $select) : ResultSetInterface
    {
        return $this->tableGateway->selectWith($select);
    }

    /**
     * @param \Zend\Db\Sql\Select $select
     * @return int
     */
    protected function fetchCount(Select $select)
    {
        $statement  = $this->tableGateway->getSql()->prepareStatementForSqlObject($select);
        $results = $statement->execute();

        return $results->current()[self::COUNT_COLUMN];
    }
}
