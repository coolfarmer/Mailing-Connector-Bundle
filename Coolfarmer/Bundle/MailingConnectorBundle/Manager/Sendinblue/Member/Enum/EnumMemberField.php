<?php

namespace coolfarmer\MailingConnectorBundle\Manager\Sendinblue\Member\Enum;

/**
 * Class EnumMemberField
 *
 * @package coolfarmer\MailingConnectorBundle\Manager\Sendinblue\Member\Enum
 */
class EnumMemberField
{
    const LONG_NAME = __CLASS__;

    const FIRSTNAME = 'FIRSTNAME';
    const LASTNAME = 'LASTNAME';
    const EMAIL = 'EMAIL';

    
    /**
     * @return array
     */
    public static function getSupportedValues()
    {
        return array(
            self::FIRSTNAME,
            self::LASTNAME,
            self::EMAIL,
        );
    }
} 