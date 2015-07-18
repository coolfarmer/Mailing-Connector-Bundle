<?php

namespace coolfarmer\MailingConnectorBundle\Member\Enum;

/**
 * Class EnumMemberField
 *
 * @package coolfarmer\MailingConnectorBundle\Member\Enum
 */
class EnumMemberField
{
    const LONG_NAME = __CLASS__;

    const FIRSTNAME = 'FIRSTNAME';
    const LASTNAME = 'LASTNAME';
    const EMAIL = 'EMAIL';
    const CELLPHONE = 'CELLPHONE';
    const BIRTHDAY_DATE = 'BIRTHDAY_DATE';
    const DATE_SUBSCRIBE = 'DATE_SUBSCRIBE';


    /**
     * @return array
     */
    public static function getMandatoryValues()
    {
        return array(
            self::EMAIL,
        );
    }
    
    /**
     * @return array
     */
    public static function getSupportedValues()
    {
        return array(
            self::FIRSTNAME,
            self::LASTNAME,
            self::EMAIL,
            self::CELLPHONE,
            self::BIRTHDAY_DATE,
            self::DATE_SUBSCRIBE,
        );
    }
} 