<?php

namespace coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\BatchMember;

/**
 * Class Column
 *
 * @package coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\BatchMember
 */
class Column
{
    const CLASS_NAME = __CLASS__;
    
    /**
     * @var string
     */
    private $fieldName;

    /**
     * @var bool
     */
    private $toReplace;

    /**
     * @var string
     */
    private $dateFormat;

    /**
     * @var string
     */
    private $defaultValue;

    
    /**
     * @param string $fieldName
     * @param bool $toReplace
     * @param null|string $dateFormat
     * @param null|string $defaultValue
     */
    public function __construct($fieldName, $toReplace = false, $dateFormat = null, $defaultValue = null)
    {
        $this->fieldName = $fieldName;
        $this->toReplace = $toReplace;
        $this->dateFormat = $dateFormat;
        $this->defaultValue = $defaultValue;
    }

    /**
     * @return string
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * @return bool
     */
    public function getToReplace()
    {
        return $this->toReplace;
    }
    
    /**
     * @return null|string
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    /**
     * @return null|string
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }
} 