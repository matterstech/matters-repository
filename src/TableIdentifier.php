<?php
/**
 * @author Matters Studio (https://matters.tech)
 */

namespace Matters;

use Zend\Db\Sql\TableIdentifier as ZendTableIdentifier;

class TableIdentifier extends ZendTableIdentifier
{
    public function column(string $columnName)
    {
        return new Column($columnName, new self($this->table, $this->schema));
    }

    public function getFullName()
    {
        if (!$this->schema) {
            return sprintf('"%s"', $this->table);
        }
        return sprintf('"%s"."%s"', $this->schema, $this->table);
    }
}
