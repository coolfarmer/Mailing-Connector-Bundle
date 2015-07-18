<?php

namespace coolfarmer\MailingConnectorBundle\Converter;

/**
 * Class StringToPascalCase
 *
 * @package coolfarmer\MailingConnectorBundle\Converter
 */
class StringToPascalCase
{
    /**
     * Convert a string to PascalCase
     * 
     * @param string $string
     *
     * @return string
     * @throws \Exception
     */
    public static function convert($string)
    {
        if (empty($string)) {
            throw new \Exception('String cannot be empty.');
        }
        
        return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $string)));
    }
} 