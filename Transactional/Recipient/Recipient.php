<?php

namespace coolfarmer\MailingConnectorBundle\Transactional\Recipient;

/**
 * Class Recipient
 *
 * @pacoolfarmer\MailingConnectorBundlenector\Transactional\Recipient
 */
class Recipient
{
    const CLASS_NAME = __CLASS__;

    /**
     * @var mixed
     */
    private $value;

    
    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
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