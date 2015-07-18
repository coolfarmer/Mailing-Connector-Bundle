<?php

namespace coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\BatchMember;

/**
 * Class Mapping
 *
 * @package coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\BatchMember
 */
class Mapping
{
    /**
     * @var ColumnCollection
     */
    private $columns;
    
    
    public function __construct()
    {
        $this->columns = new ColumnCollection();
    }

    /**
     * Add a column
     * 
     * @param string $fieldName
     * @param bool $toReplace
     * @param null|string $dateFormat
     * @param null|string $defaultValue
     *
     * @return $this
     */
    public function addColumn($fieldName, $toReplace = false, $dateFormat = null, $defaultValue = null)
    {
        $column = new Column($fieldName, $toReplace, $dateFormat, $defaultValue);
        $this->columns->addColumn($column);
        
        return $this;
    }

    /**
     * @return ColumnCollection
     */
    public function getColumns()
    {
        return $this->columns;
    }
} 