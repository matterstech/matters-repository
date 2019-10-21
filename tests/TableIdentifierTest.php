<?php


namespace Matters;

use PHPUnit\Framework\TestCase;
use Zend\Db\Adapter\Platform\Postgresql;
use Zend\Db\Sql\Select;

class TableIdentifierTest extends TestCase
{
    public function testSelect_simpleTable()
    {
        $groupTable = new TableIdentifier('group');
        $select = (new Select())->from($groupTable);

        $ownerId = $groupTable->column('owner_id');

        $select->columns(['owner_id' => $ownerId]);

        self::assertSame(
            'SELECT "group".owner_id AS "owner_id" FROM "group"',
            $select->getSqlString()
        );
    }
    public function testSelect_tableWithSchema()
    {
        $groupTable = new TableIdentifier('group', 'invoicing');
        $select = (new Select())->from($groupTable);

        $ownerId = $groupTable->column('owner_id');

        $select->columns(['owner_id' => $ownerId]);

        $select->where
            ->equalTo($ownerId, 4);

        $platform = new class extends Postgresql
        {
            public function quoteValue($value)
            {
                return $value;
            }
        };

        self::assertSame(
            'SELECT "invoicing"."group".owner_id AS "owner_id" FROM "invoicing"."group" WHERE "invoicing"."group".owner_id = 4',
            $select->getSqlString($platform)
        );
    }
}