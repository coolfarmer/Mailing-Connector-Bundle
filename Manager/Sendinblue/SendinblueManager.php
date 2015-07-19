<?php

namespace coolfarmer\MailingConnectorBundle\Manager\Sendinblue;

use coolfarmer\MailingConnectorBundle\Manager\Manager;
use coolfarmer\MailingConnectorBundle\Manager\Sendinblue\Service\MemberService as SbManagerMemberService;
use coolfarmer\MailingConnectorBundle\Manager\Sendinblue\Service\NotificationService as SbManagerNotificationService;
use Sendinblue\Mailin;

/**
 * Class SendinblueManager
 *
 * @package coolfarmer\MailingConnectorBundle\Manager\Sendinblue
 */
class SendinblueManager implements Manager
{
    /**
     * @var Mailin
     */
    private $api;


    /**
     * Create SendinBlue instance
     *
     * @param string $key
     * @param string $server
     */
    public function __construct($key, $server)
    {
        $this->api = $this->createRestApiClient($key, $server);
    }

    /**
     * This service allows to access your members’ profile through the Manager API.
     * Allowing you to insert, update, and get a member profile.
     *
     * @return SbManagerMemberService
     */
    public function getMemberService()
    {
        return new SbManagerMemberService($this->api);
    }

    /**
     * This service allows you to send transactional email
     *
     * @return SbManagerNotificationService
     */
    public function getNotificationService()
    {
        return new SbManagerNotificationService($this->api);
    }

    /**
     * This service allows you import a batch of members
     *
     * @throws \Exception
     */
    public function getImportMemberService()
    {
        throw new \Exception('Service "import batch member" is not yet available.');
    }

    /**
     * @param string $key
     * @param string $server
     *
     * @return Mailin
     */
    private function createRestApiClient($key, $server)
    {
        return new Mailin($server, $key);
    }
} 