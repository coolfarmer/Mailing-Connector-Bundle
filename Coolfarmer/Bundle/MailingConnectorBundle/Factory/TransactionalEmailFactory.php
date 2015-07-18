<?php

namespace coolfarmer\MailingConnectorBundle\Factory;

use coolfarmer\MailingConnectorBundle\Transactional\TransactionalEmail;

/**
 * Class TransactionalEmailFactory
 *
 * @package coolfarmer\MailingConnectorBundle\Factory
 */
class TransactionalEmailFactory
{
    /**
     * Create new transactional email
     *
     * @param int $templateId
     * @param string $recipient
     *
     * @throws \Exception
     * @return TransactionalEmail
     */
    public static function create($templateId, $recipient)
    {
        if (empty($templateId)) {
            throw new \Exception('Transactional email must have at least a unique identifier.');
        }
        if (empty($recipient)) {
            throw new \Exception('Transactional email must have at least one recipient.');
        }
        
        return new TransactionalEmail($templateId, $recipient);
    }
} 