<?php

namespace coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Service;

use coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Transactional\Enum\EnumTransactionalEmailOption;
use coolfarmer\MailingConnectorBundle\Parameter\Parameter;
use coolfarmer\MailingConnectorBundle\Parameter\ParameterCollection;
use coolfarmer\MailingConnectorBundle\Service\NotificationServiceInterface;
use coolfarmer\MailingConnectorBundle\Transactional\Recipient\Recipient;
use coolfarmer\MailingConnectorBundle\Transactional\Recipient\RecipientCollection;
use coolfarmer\MailingConnectorBundle\Transactional\TransactionalEmail;
use MyLittle\CampaignCommander\API\SOAP\ClientFactoryInterface;
use MyLittle\CampaignCommander\Service\NotificationService as CCNotificationService;

/**
 * Class NotificationService
 * 
 * This service is used to send a Transactional Message to an email address.
 *
 * @package coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Service
 */
class NotificationService implements NotificationServiceInterface
{
    const CLASS_NAME = __CLASS__;

    const SYNCHROTYPE_DEFAULT = 'NOTHING';
    const UIDKEY_DEFAULT = 'email';
    
    /**
     * @var CCNotificationService
     */
    private $service;


    /**
     * @param ClientFactoryInterface $client
     */
    public function __construct(ClientFactoryInterface $client)
    {
        $this->service = new CCNotificationService($client);
    }

    /**
     * Send a transactional email
     *
     * @param TransactionalEmail $tEmail
     *
     * @throws \Exception
     */
    public function send(TransactionalEmail $tEmail)
    {
        $this->sendCheckSupportedOptions($tEmail);
        $this->sendCheckMandatoryOptions($tEmail);
        
        $options = $tEmail->getOptions();
        $random = $options->getParameterByName('random');
        $encrypt = $options->getParameterByName('encrypt');
        $content = $options->getParameterByName('content');
        
        if (null !== $content) {
            $content = $content->getValue();
        }
        $recipientsList = $this->handleRecipients($tEmail->getRecipients(), 1);
        
        $this->service->sendObject(
            $tEmail->getTemplateId(),
            $random->getValue(),
            $encrypt->getValue(),
            $recipientsList[0],
            $this->handleAttributes($tEmail->getAttributes()),
            $content,
            self::SYNCHROTYPE_DEFAULT,
            null,
            self::UIDKEY_DEFAULT
        );
    }

    /**
     * Checking if mandatory options are there
     * 
     * @param TransactionalEmail $tEmail
     *
     * @throws \Exception
     */
    private function sendCheckMandatoryOptions(TransactionalEmail $tEmail)
    {
        $options = $tEmail->getOptions();
        foreach (EnumTransactionalEmailOption::getMandatoryValue() as $option) {
            if (null === $options->getParameterByName($option)) {
                throw new \Exception(
                    'Transactional email : Required option (' . $option . ') was missing.'
                );
            }
        }
    }

    /**
     * Checking if we receive a not supported option
     * 
     * @param TransactionalEmail $tEmail
     *
     * @throws \Exception
     */
    private function sendCheckSupportedOptions(TransactionalEmail $tEmail)
    {
        $supportedValues = EnumTransactionalEmailOption::getSupportedValues();
        foreach ($tEmail->getOptions() as $option) {
            if (!in_array($option, $supportedValues)) {
                throw new \Exception(
                    'Transactional email : This option (' . $option . ') is not supported by CampaignCommander.'
                );
            }
        }
    }

    /**
     * Handle recipient collection and return a numeric array
     * 
     * @param RecipientCollection $recipientCollection
     * @param bool $limit
     *
     * @return array  List of recipients
     */
    private function handleRecipients(RecipientCollection $recipientCollection, $limit = false)
    {
        $list = array();
        /** @var Recipient $recipient */
        foreach ($recipientCollection->toArray() as $recipient) {
            $list[] = $recipient->getValue();
            if (count($list) >= $limit) {
                break;
            }
        }
        
        return $list;
    }

    /**
     * Handle attribute collection and return an associative array
     * 
     * @param ParameterCollection $attributeCollection
     *
     * @return array  List of attributes
     */
    private function handleAttributes(ParameterCollection $attributeCollection)
    {
        $attributes = array();
        /** @var Parameter $attribute */
        foreach ($attributeCollection->toArray() as $attribute) {
            $attributes[$attribute->getKey()] = $attribute->getValue();
        }

        return $attributes;
    }
} 