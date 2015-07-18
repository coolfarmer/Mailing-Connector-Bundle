<?php

namespace coolfarmer\MailingConnectorBundle\Parameter;

/**
 * Class Parameter
 *
 * @package coolfarmer\MailingConnectorBundle\Parameter
 */
class Parameter
{
    const CLASS_NAME = __CLASS__;

    /**
     * @var string
     */
    private $key;

    /**
     * @var mixed
     */
    private $value;

    
    /**
     * @param string $key
     * @param mixed $value
     */
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
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