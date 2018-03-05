<?php
/**
 * @author Matters Studio (https://matters.tech)
 */

namespace Matters\ValueObjects;

/**
 * Class QueryFilter
 * @package Matters\ValueObjects
 */
class QueryFilter
{
    /** @var string */
    private $field;

    /** @var string */
    private $type;

    /** @var string */
    private $value;

    /**
     * QueryFilter constructor.
     * @param string $field
     * @param string $type
     * @param mixed $value
     */
    public function __construct(string $field, string $type, $value)
    {
        $this->field = $field;
        $this->type  = $type;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getField() : string
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
