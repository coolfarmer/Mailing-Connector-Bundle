<?php

namespace coolfarmer\MailingConnectorBundle\Manager;

/**
 * Interface Manager
 *
 * @package coolfarmer\MailingConnectorBundle\Manager
 */
interface Manager
{
    /**
     * This service allows to access your members’ profile through the Manager API.
     * Allowing you to insert, update, and get a member profile.
     * 
     * @return object
     */
    public function getMemberService();

    /**
     * This service allows you to send transactional email.
     * 
     * @return object
     */
    public function getNotificationService();

    /**
     * This service allows you import a batch of members.
     *
     * @return object
     */
    public function getImportMemberService();
} 