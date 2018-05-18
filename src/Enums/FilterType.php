<?php
/**
 * @author Matters Studio (https://matters.tech)
 */

namespace Matters\Enums;

/**
 * Class FilterType
 * @package Matters\Enums
 */
class FilterType
{
    const EQUAL_TO                 = 'eq';
    const GREATER_THAN             = 'gt';
    const GREATER_THAN_OR_EQUAL_TO = 'gte';
    const LESS_THAN                = 'lt';
    const LESS_THAN_OR_EQUAL_TO    = 'lte';
    const LIKE                     = 'like';
    const IN                       = 'in';

    /**
     * Return query filter types
     * @return array
     */
    public static function getAll()
    {
        return [
            self::EQUAL_TO,
            self::GREATER_THAN,
            self::GREATER_THAN_OR_EQUAL_TO,
            self::LESS_THAN,
            self::LESS_THAN_OR_EQUAL_TO,
            self::LIKE,
            self::IN,
        ];
    }
}
