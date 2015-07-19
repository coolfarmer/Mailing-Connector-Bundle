<?php

namespace coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\BatchMember;

use Star\Component\Collection\TypedCollection;

/**
 * Class ColumnCollection
 *
 * @package coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\BatchMember
 */
class ColumnCollection
{
    const CLASS_NAME = __CLASS__;

    /**
     * @var Column[]
     */
    private $collection;


    public function __construct()
    {
        $this->collection = new TypedCollection(Column::CLASS_NAME);
    }

    /**
     * @param Column $column
     */
    public function addColumn(Column $column)
    {
        $this->collection->add($column);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->collection->toArray();
    }
} 