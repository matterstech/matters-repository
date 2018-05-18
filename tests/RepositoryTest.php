<?php
/**
 * @author Matters Studio (https://matters.tech)
 */

namespace Matters;

use Matters\Enums\FilterType;
use Matters\ValueObjects\QueryFilter;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

/**
 * Class RepositoryTest
 * @package Matters
 */
class RepositoryTest extends TestCase
{
    /**
     * @var Repository
     */
    private $testedInstance;

    /**
     * @var m\MockInterface
     */
    private $tableGateway;

    protected function setUp()
    {
        $this->tableGateway = m::mock(TableGateway::class);

        $this->testedInstance = new class($this->tableGateway) extends Repository {};
    }

    public function testInstance()
    {
        self::assertInstanceOf(Repository::class, $this->testedInstance);
    }

    public function applyQueryFiltersProvider()
    {
        return [
            [
                [],
                [
                    'equal-to-nb-calls'                 => 0,
                    'greater-than-nb-calls'             => 0,
                    'greater-than-or-equal-to-nb-calls' => 0,
                    'less-than-nb-calls'                => 0,
                    'less-than-or-equal-to-nb-calls'    => 0,
                    'like-nb-calls'                     => 0,
                    'in-nb-calls'                       => 0,
                ],
            ],
            [
                [
                    new QueryFilter('key', FilterType::EQUAL_TO, 'value'),
                ],
                [
                    'equal-to-nb-calls'                 => 1,
                    'greater-than-nb-calls'             => 0,
                    'greater-than-or-equal-to-nb-calls' => 0,
                    'less-than-nb-calls'                => 0,
                    'less-than-or-equal-to-nb-calls'    => 0,
                    'like-nb-calls'                     => 0,
                    'in-nb-calls'                       => 0,
                ],
            ],
            [
                [
                    new QueryFilter('key', FilterType::GREATER_THAN, 'value'),
                ],
                [
                    'equal-to-nb-calls'                 => 0,
                    'greater-than-nb-calls'             => 1,
                    'greater-than-or-equal-to-nb-calls' => 0,
                    'less-than-nb-calls'                => 0,
                    'less-than-or-equal-to-nb-calls'    => 0,
                    'like-nb-calls'                     => 0,
                    'in-nb-calls'                       => 0,
                ],
            ],
            [
                [
                    new QueryFilter('key', FilterType::GREATER_THAN_OR_EQUAL_TO, 'value'),
                ],
                [
                    'equal-to-nb-calls'                 => 0,
                    'greater-than-nb-calls'             => 0,
                    'greater-than-or-equal-to-nb-calls' => 1,
                    'less-than-nb-calls'                => 0,
                    'less-than-or-equal-to-nb-calls'    => 0,
                    'like-nb-calls'                     => 0,
                    'in-nb-calls'                       => 0,
                ],
            ],
            [
                [
                    new QueryFilter('key', FilterType::LESS_THAN, 'value'),
                ],
                [
                    'equal-to-nb-calls'                 => 0,
                    'greater-than-nb-calls'             => 0,
                    'greater-than-or-equal-to-nb-calls' => 0,
                    'less-than-nb-calls'                => 1,
                    'less-than-or-equal-to-nb-calls'    => 0,
                    'like-nb-calls'                     => 0,
                    'in-nb-calls'                       => 0,
                ],
            ],
            [
                [
                    new QueryFilter('key', FilterType::LESS_THAN_OR_EQUAL_TO, 'value'),
                ],
                [
                    'equal-to-nb-calls'                 => 0,
                    'greater-than-nb-calls'             => 0,
                    'greater-than-or-equal-to-nb-calls' => 0,
                    'less-than-nb-calls'                => 0,
                    'less-than-or-equal-to-nb-calls'    => 1,
                    'like-nb-calls'                     => 0,
                    'in-nb-calls'                       => 0,
                ],
            ],
            [
                [
                    new QueryFilter('key', FilterType::LIKE, 'value'),
                ],
                [
                    'equal-to-nb-calls'                 => 0,
                    'greater-than-nb-calls'             => 0,
                    'greater-than-or-equal-to-nb-calls' => 0,
                    'less-than-nb-calls'                => 0,
                    'less-than-or-equal-to-nb-calls'    => 0,
                    'like-nb-calls'                     => 1,
                    'in-nb-calls'                       => 0,
                ],
            ],
            [
                [
                    new QueryFilter('key', FilterType::EQUAL_TO, 'value'),
                    new QueryFilter('key', FilterType::GREATER_THAN, 'value'),
                ],
                [
                    'equal-to-nb-calls'                 => 1,
                    'greater-than-nb-calls'             => 1,
                    'greater-than-or-equal-to-nb-calls' => 0,
                    'less-than-nb-calls'                => 0,
                    'less-than-or-equal-to-nb-calls'    => 0,
                    'like-nb-calls'                     => 0,
                    'in-nb-calls'                       => 0,
                ],
            ],
            [
                [
                    new QueryFilter('key', FilterType::LESS_THAN, 'value'),
                    new QueryFilter('key', FilterType::LIKE, 'value'),
                ],
                [
                    'equal-to-nb-calls'                 => 0,
                    'greater-than-nb-calls'             => 0,
                    'greater-than-or-equal-to-nb-calls' => 0,
                    'less-than-nb-calls'                => 1,
                    'less-than-or-equal-to-nb-calls'    => 0,
                    'like-nb-calls'                     => 1,
                    'in-nb-calls'                       => 0,
                ],
            ],
            [
                [
                    new QueryFilter('key', FilterType::IN, ['value']),
                ],
                [
                    'equal-to-nb-calls'                 => 0,
                    'greater-than-nb-calls'             => 0,
                    'greater-than-or-equal-to-nb-calls' => 0,
                    'less-than-nb-calls'                => 0,
                    'less-than-or-equal-to-nb-calls'    => 0,
                    'like-nb-calls'                     => 0,
                    'in-nb-calls'                       => 1,
                ],
            ],
        ];
    }

    /**
     * @dataProvider applyQueryFiltersProvider
     * @param array $filters
     * @param array $nbCalls
     */
    public function testApplyQueryFilters(array $filters, array $nbCalls)
    {
        $where = m::mock(Where::class);
        $where
            ->shouldReceive('equalTo')
            ->with('key', 'value')
            ->times($nbCalls['equal-to-nb-calls']);
        $where
            ->shouldReceive('greaterThan')
            ->with('key', 'value')
            ->times($nbCalls['greater-than-nb-calls']);
        $where
            ->shouldReceive('greaterThanOrEqualTo')
            ->with('key', 'value')
            ->times($nbCalls['greater-than-or-equal-to-nb-calls']);
        $where
            ->shouldReceive('lessThan')
            ->with('key', 'value')
            ->times($nbCalls['less-than-nb-calls']);
        $where
            ->shouldReceive('lessThanOrEqualTo')
            ->with('key', 'value')
            ->times($nbCalls['less-than-or-equal-to-nb-calls']);
        $where
            ->shouldReceive('like')
            ->with('key', '%value%')
            ->times($nbCalls['like-nb-calls']);
        $where
            ->shouldReceive('in')
            ->with('key', ['value'])
            ->times($nbCalls['in-nb-calls']);

        self::assertSame($where, $this->testedInstance->applyQueryFilters($where, $filters));
    }
}
