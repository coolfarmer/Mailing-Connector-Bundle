<?php

namespace coolfarmer\MailingConnectorBundle\Member\Enum;

/**
 * Class EnumMemberCustomField
 *
 * @package coolfarmer\MailingConnectorBundle\Member\Enum
 */
class EnumMemberCustomField
{
    const LONG_NAME = __CLASS__;

    const COUNTRY = 'COUNTRY';

    
    /**
     * @return array
     */
    public static function getSupportedValues()
    {
        return array(
            self::COUNTRY,
        );
    }
} 