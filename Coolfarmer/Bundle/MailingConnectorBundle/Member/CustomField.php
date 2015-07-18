<?php

namespace coolfarmer\MailingConnectorBundle\Member;

/**
 * Class CustomField
 *
 * @package coolfarmer\MailingConnectorBundle\Member
 */
class CustomField
{
    const CLASS_NAME = __CLASS__;

    /**
     * @var string
     */
    private $field;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param string $field
     * @param mixed $value
     */
    public function __construct($field, $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
} 