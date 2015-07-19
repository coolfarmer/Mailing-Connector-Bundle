<?php

namespace coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Transactional\Enum;

/**
 * Class EnumTransactionalEmailOption
 *
 * @package coolfarmer\MailingConnectorBundle\Member\CustomField\Enum
 */
class EnumTransactionalEmailOption
{
    const LONG_NAME = __CLASS__;

    /**
     * The encrypt value provided in the interface
     */
    const ENCRYPT = 'encrypt';

    /**
     * The random value provided for the Template
     */
    const RANDOM = 'random';
    
    /**
     * The type of synchronization that should be carried out: NOTHING, INSERT, UPDATE, INSERT_UPDATE
     */
    const SYNCHROTYPE = 'synchrotype';

    /**
     * The content parameter envelope
     */
    const CONTENT = 'content';
    

    /**
     * @return array
     */
    public static function getMandatoryValue()
    {
        return array(
            self::ENCRYPT,
            self::RANDOM,
        );
    }
    
    /**
     * @return array
     */
    public static function getSupportedValues()
    {
        return array(
            self::ENCRYPT,
            self::RANDOM,
            self::SYNCHROTYPE,
            self::CONTENT,
        );
    }
} 