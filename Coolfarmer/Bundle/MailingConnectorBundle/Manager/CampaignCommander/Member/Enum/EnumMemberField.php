<?php

namespace coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Member\Enum;

/**
 * Class EnumMemberField
 *
 * @package coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Member\Enum
 */
class EnumMemberField
{
    const LONG_NAME = __CLASS__;

    const FIRSTNAME = 'FIRSTNAME';
    const LASTNAME = 'LASTNAME';
    const EMAIL_ORIGINE = 'EMAIL_ORIGINE';
    const EMAIL = 'EMAIL';
    const EMVCELLPHONE = 'EMVCELLPHONE';
    const EMAIL_FORMAT = 'EMAIL_FORMAT';
    const TITLE = 'TITLE';
    const DATEOFBIRTH = 'DATEOFBIRTH';
    const SEED = 'SEED';
    const CLIENTURN = 'CLIENTURN';
    const SOURCE = 'SOURCE';
    const CODE = 'CODE';
    const SEGMENT = 'SEGMENT';

    
    /**
     * @return array
     */
    public static function getSupportedValues()
    {
        return array(
            self::FIRSTNAME,
            self::LASTNAME,
            self::EMAIL_ORIGINE,
            self::EMAIL,
            self::EMVCELLPHONE,
            self::EMAIL_FORMAT,
            self::TITLE,
            self::DATEOFBIRTH,
            self::SEED,
            self::CLIENTURN,
            self::SOURCE,
            self::CODE,
            self::SEGMENT,
        );
    }
} 