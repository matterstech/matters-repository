<?php

namespace Matters\Select;

use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\TableIdentifier;

class Exists extends Select
{
    const EXISTS_ALIAS = 'exists';

    const EXISTS_EXPRESSION = "'exists'";

    /**
     * @param  null|string|array|TableIdentifier $table
     */
    public function __construct($table = null)
    {
        parent::__construct($table);
        parent::columns([
            self::EXISTS_ALIAS => new Expression(self::EXISTS_EXPRESSION)
        ]);
        parent::limit(1);
    }

    public function columns(array $columns, $prefixColumnsWithTable = true)
    {
        throw new \BadMethodCallException('The columns should not be changed');
    }

    public function limit($limit)
    {
        throw new \BadMethodCallException('The columns should not be changed');
    }
}