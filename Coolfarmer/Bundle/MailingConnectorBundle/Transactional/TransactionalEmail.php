<?php

namespace coolfarmer\MailingConnectorBundle\Transactional;

use coolfarmer\MailingConnectorBundle\Parameter\ParameterCollection;
use coolfarmer\MailingConnectorBundle\Transactional\Recipient\RecipientCollection;

/**
 * Class TransactionalEmail
 *
 * @package coolfarmer\MailingConnectorBundle\Transactional
 */
class TransactionalEmail
{
    const CLASS_NAME = __CLASS__;

    /**
     * Template unique ID
     * 
     * @var string
     */
    private $templateId;

    /**
     * TO
     * 
     * @var RecipientCollection
     */
    private $recipientCollection;

    /**
     * CC
     * 
     * @var RecipientCollection
     */
    private $carbonCopyCollection;

    /**
     * BBC
     * 
     * @var RecipientCollection
     */
    private $blindCarbonCopyCollection;

    /**
     * Template variables
     * 
     * @var ParameterCollection
     */
    private $attributes;

    /**
     * TransactionalEmail extension
     * 
     * @var ParameterCollection
     */
    private $options;


    /**
     * @param string $templateId
     * @param string $recipient
     */
    public function __construct($templateId, $recipient)
    {
        $this->templateId = $templateId;
        $this->recipientCollection = new RecipientCollection();
        $this->carbonCopyCollection = new RecipientCollection();
        $this->blindCarbonCopyCollection = new RecipientCollection();
        $this->attributes = new ParameterCollection();
        $this->options = new ParameterCollection();
        
        $this->addRecipient($recipient);
    }

    /**
     * @return string
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }

    /**
     * @return RecipientCollection
     */
    public function getRecipients()
    {
        return $this->recipientCollection;
    }

    /**
     * @return RecipientCollection
     */
    public function getCarbonCopies()
    {
        return $this->carbonCopyCollection;
    }

    /**
     * @return RecipientCollection
     */
    public function getBlindCarbonCopies()
    {
        return $this->blindCarbonCopyCollection;
    }

    /**
     * Add a recipient
     *
     * @param string $email
     *
     * @return $this
     */
    public function addRecipient($email)
    {
        $this->recipientCollection->addRecipientByValue($email);
        
        return $this;
    }

    /**
     * Add a recipient as CarbonCopy
     *
     * @param string $email
     *
     * @return $this
     */
    public function addCarbonCopy($email)
    {
        $this->carbonCopyCollection->addRecipientByValue($email);
        
        return $this;
    }

    /**
     * Add a recipient as BlindCarbonCopy
     *
     * @param string $email
     *
     * @return $this
     */
    public function addBlindCarbonCopy($email)
    {
        $this->blindCarbonCopyCollection->addRecipientByValue($email);
        
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function addAttributes($key, $value)
    {
        $this->attributes->addParameterByKeyValue($key, $value);
        
        return $this;
    }

    /**
     * @return ParameterCollection
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function addOption($key, $value)
    {
        $this->options->addParameterByKeyValue($key, $value);
        
        return $this;
    }

    /**
     * @return ParameterCollection
     */
    public function getOptions()
    {
        return $this->options;
    }
} 