<?php
/**
 * @author      Matters Studio (https://matters.tech)
 */

namespace Matters;

use Matters\Enums\FilterType;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\Sql\Literal;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
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

    /**
     * @param \Zend\Db\Sql\Where $where
     * @param array $filters
     * @return \Zend\Db\Sql\Where
     */
    public function applyQueryFilters(Where $where, array $filters)
    {
        /** @var \Matters\ValueObjects\QueryFilter $filter */
        foreach ($filters as $filter) {
            switch ($filter->getType()) {
                case FilterType::EQUAL_TO:
                    $where->equalTo($filter->getField(), $filter->getValue());
                    break;
                case FilterType::GREATER_THAN:
                    $where->greaterThan($filter->getField(), $filter->getValue());
                    break;
                case FilterType::GREATER_THAN_OR_EQUAL_TO:
                    $where->greaterThanOrEqualTo($filter->getField(), $filter->getValue());
                    break;
                case FilterType::LESS_THAN:
                    $where->lessThan($filter->getField(), $filter->getValue());
                    break;
                case FilterType::LESS_THAN_OR_EQUAL_TO:
                    $where->lessThanOrEqualTo($filter->getField(), $filter->getValue());
                    break;
                case FilterType::LIKE:
                    $where->like($filter->getField(), '%' . $filter->getValue() . '%');
                    break;
                default:
                    break;
            }
        }

        return $where;
    }
}
