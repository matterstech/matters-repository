<?php

namespace Matters;

use PHPUnit\Framework\TestCase;
use Zend\Db\TableGateway\TableGateway;


/**
 * Class RepositoryTest
 * @package Matters
 */
class RepositoryTest extends TestCase
{
    private $testedInstance;

    protected function setUp()
    {
        $this->tableGateway = $this->prophesize(TableGateway::class);

        $this->testedInstance = new class($this->tableGateway->reveal()) extends Repository {};
    }

    public function testInstance()
    {
        self::assertInstanceOf(Repository::class, $this->testedInstance);
    }
}