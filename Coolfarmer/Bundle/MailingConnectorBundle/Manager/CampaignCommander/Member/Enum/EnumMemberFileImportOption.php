<?php

namespace coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Member\Enum;

/**
 * Class EnumMemberFileImportOption
 *
 * @package coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Member\Enum
 */
class EnumMemberFileImportOption
{
    const LONG_NAME = __CLASS__;

    /**
     * Skips the first line in the file (default value is false)
     */
    const SKIPFIRSTLINE = 'skipFirstLine';

    /**
     * The field to use as merge criteria (default value is LOWER(EMAIL))
     */
    const CRITERIA = 'criteria';

    /**
     * The date format used in the columns containing dates (default value is dd/mm/yyyy)
     */
    const DATEFORMAT = 'dateFormat';

    /**
     * The mapping envelope parameter containing the column mapping definitions.
     */
    const MAPPING = 'mapping';

    /**
     * The content ID of the attachment to upload or the Base64-encoded file content.
     */
    const FILE = 'file';

    
    /**
     * @return array
     */
    public static function getMandatoryValues()
    {
        return array(
            self::FILE,
        );
    }
    
    /**
     * @return array
     */
    public static function getSupportedValues()
    {
        return array(
            self::SKIPFIRSTLINE,
            self::CRITERIA,
            self::DATEFORMAT,
            self::FILE,
        );
    }
} 