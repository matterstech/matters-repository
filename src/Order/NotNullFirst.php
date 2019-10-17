<?php

namespace Matters\Order;

use Matters\Column;
use Zend\Db\Sql\Expression;

class NotNullFirst extends Expression
{
    public function __construct(Column $column)
    {
        $expression = 'ISNULL(%s) ASC';
        parent::__construct(
            sprintf($expression, $column->getExpression())
        );
    }
}