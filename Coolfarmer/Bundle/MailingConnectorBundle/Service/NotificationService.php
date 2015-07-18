<?php

namespace coolfarmer\MailingConnectorBundle\Service;

use coolfarmer\MailingConnectorBundle\Manager\Manager;
use coolfarmer\MailingConnectorBundle\Transactional\TransactionalEmail;

/**
 * Class NotificationService
 *
 * This service allows you to send transactional emails.
 * 
 * @package coolfarmer\MailingConnectorBundle\Service
 */
class NotificationService implements NotificationServiceInterface
{
    const CLASS_NAME = __CLASS__;

    /**
     * @var Manager
     */
    private $manager;


    /**
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Send transactional email
     *
     * @param TransactionalEmail $tEmail
     */
    public function send(TransactionalEmail $tEmail)
    {
        $this->manager->getNotificationService()->send($tEmail);
    }
} 