<?php

namespace Matters\Select;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Zend\Db\Adapter\Platform\Postgresql;

class ExistsTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testInstance()
    {
        $select = (new Exists())->from('potatoes');
        $select->where('potato_id = 42');

        $platform = new class extends Postgresql
        {
            public function quoteValue($value)
            {
                return '"'. $value .'"';
            }
        };

        self::assertSame('SELECT \'exists\' AS "exists" FROM "potatoes" WHERE potato_id = 42 LIMIT "1"', $select->getSqlString($platform));
    }
}
