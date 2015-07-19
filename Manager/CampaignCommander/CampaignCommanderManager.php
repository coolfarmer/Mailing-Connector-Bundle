<?php

namespace coolfarmer\MailingConnectorBundle\Manager\CampaignCommander;

use BeSimple\SoapClient as Soap;
use MyLittle\CampaignCommander\API\SOAP as Client;
use MyLittle\CampaignCommander\API\SOAP\ClientFactoryInterface;
use coolfarmer\MailingConnectorBundle\Manager\Manager;
use coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Service\MemberService as CCManagerMemberService;
use coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Service\BatchMemberService as CCManagerBatchMemberService;
use coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Service\NotificationService as CCManagerNotificationService;

/**
 * Class CampaignCommanderManager
 *
 * @package coolfarmer\MailingConnectorBundle\Manager\CampaignCommander
 */
class CampaignCommanderManager implements Manager
{
    const CLASS_NAME = __CLASS__;
    const NOTIFICATION_API_SERVER = 'http://api.notificationmessaging.com';
    
    /**
     * @var ClientFactoryInterface
     */
    private $client;
    
    
    /**
     * Create CampaignCommander instance
     * 
     * @param string $login
     * @param string $password
     * @param string $key
     * @param string $server
     */
    public function __construct($login, $password, $key, $server)
    {
        $this->client = $this->createStandardClientWithAuth($login, $password, $key, $server);
    }

    /**
     * This service allows to access your members’ profile through the Manager API.
     * Allowing you to insert, update, and get a member profile.
     * 
     * @return CCManagerMemberService
     */
    public function getMemberService()
    {
        return new CCManagerMemberService($this->client);
    }

    /**
     * This service allows you to send transactional email
     * 
     * @return CCManagerNotificationService
     */
    public function getNotificationService()
    {
        // Override client
        $client = $this->createStandardClientWithoutAuth(self::NOTIFICATION_API_SERVER);
        
        return new CCManagerNotificationService($client);
    }

    /**
     * This service allows you import a batch of members
     * 
     * @return CCManagerBatchMemberService
     */
    public function getImportMemberService()
    {
        return new CCManagerBatchMemberService($this->client);
    }

    /**
     * Create standard client with authentication
     *
     * @param string $login
     * @param string $password
     * @param string $key
     * @param string $server
     *
     * @return ClientFactoryInterface
     */
    private function createStandardClientWithAuth($login, $password, $key, $server)
    {
        return new Client\StandardClientFactory(
            new Soap\SoapClientBuilder(),
            $login,
            $password,
            $key,
            $server
        );
    }

    /**
     * Create standard client without authentication
     *
     * @param string $server
     *
     * @return ClientFactoryInterface
     */
    private function createStandardClientWithoutAuth($server)
    {
        return new Client\StandardNoAuthClientFactory(
            new Soap\SoapClientBuilder(),
            $server
        );
    }
} 