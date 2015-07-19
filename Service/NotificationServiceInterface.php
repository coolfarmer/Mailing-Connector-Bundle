<?php

namespace coolfarmer\MailingConnectorBundle\Service;

use coolfarmer\MailingConnectorBundle\Transactional\TransactionalEmail;

/**
 * Interface NotificationServiceInterface
 *
 * @package coolfarmer\MailingConnectorBundle\Service
 */
interface NotificationServiceInterface
{
    /**
     * @param TransactionalEmail $tEmail
     */
    public function send(TransactionalEmail $tEmail);
} 