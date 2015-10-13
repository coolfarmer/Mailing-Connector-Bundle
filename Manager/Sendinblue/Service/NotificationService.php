<?php

namespace coolfarmer\MailingConnectorBundle\Manager\Sendinblue\Service;

use coolfarmer\MailingConnectorBundle\Converter\StringToPascalCase;
use coolfarmer\MailingConnectorBundle\Factory\MemberFactory;
use coolfarmer\MailingConnectorBundle\Member\Enum\EnumMemberCustomField;
use coolfarmer\MailingConnectorBundle\Member\Enum\EnumMemberField;
use coolfarmer\MailingConnectorBundle\Member\Member;
use coolfarmer\MailingConnectorBundle\Parameter\Parameter;
use coolfarmer\MailingConnectorBundle\Parameter\ParameterCollection;
use coolfarmer\MailingConnectorBundle\Service\MemberServiceInterface;
use coolfarmer\MailingConnectorBundle\Service\NotificationServiceInterface;
use coolfarmer\MailingConnectorBundle\Transactional\Recipient\Recipient;
use coolfarmer\MailingConnectorBundle\Transactional\Recipient\RecipientCollection;
use coolfarmer\MailingConnectorBundle\Transactional\TransactionalEmail;
use Sendinblue\Mailin;

/**
 * Class NotificationService
 *
 * @package coolfarmer\MailingConnectorBundle\Manager\Sendinblue
 */
class NotificationService implements NotificationServiceInterface
{
    /**
     * @var Mailin
     */
    private $service;


    /**
     * @param Mailin $api
     */
    public function __construct(Mailin $api)
    {
        $this->service = $api;
    }

    /**
     * Send a transactional email
     *
     * @param TransactionalEmail $tEmail
     */
    public function send(TransactionalEmail $tEmail)
    {
        $attributes = $this->handleAttributes($tEmail->getAttributes());
        $recipients = $this->handleRecipients($tEmail->getRecipients());
        $recipientsCc = $this->handleRecipients($tEmail->getCarbonCopies());
        $recipientsBcc = $this->handleRecipients($tEmail->getBlindCarbonCopies());

        $to = implode('|', $recipients);
        $cc = implode('|', $recipientsCc);
        $bcc = implode('|', $recipientsBcc);
        $attachmentUrl = '';
        $attachment = array();

        $this->service->send_transactional_template(
            array(
                'id' => $tEmail->getTemplateId(),
                'to' => $to,
                'cc' => $cc,
                'bcc' => $bcc,
                'attr' => $attributes,
                'attachment_url' => $attachmentUrl,
                'attachment' => $attachment,
                'headers' => array(),
            )
        );
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