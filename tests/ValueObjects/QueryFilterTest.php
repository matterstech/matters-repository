<?php
/**
 * @author Matters Studio (https://matters.tech)
 */

namespace Matters\ValueObjects;

use PHPUnit\Framework\TestCase;

/**
 * Class QueryFilterTest
 * @package Matters\ValueObjects
 */
class QueryFilterTest extends TestCase
{
    public function testConstructor()
    {
        self::assertInstanceOf(QueryFilter::class, new QueryFilter('currency', 'eq', 'EUR'));
    }

    public function testGetField()
    {
        $testedInstance = new QueryFilter('currency', 'eq', 'EUR');
        self::assertSame('currency', $testedInstance->getField());
    }

    public function testGetType()
    {
        $testedInstance = new QueryFilter('currency', 'eq', 'EUR');
        self::assertSame('eq', $testedInstance->getType());
    }

    public function testGetValue()
    {
        $testedInstance = new QueryFilter('currency', 'eq', 'EUR');
        self::assertSame('EUR', $testedInstance->getValue());
    }
}
