<?php

namespace coolfarmer\MailingConnectorBundle\Factory;

use coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\CampaignCommanderManager;
use coolfarmer\MailingConnectorBundle\Manager\Sendinblue\SendinblueManager;

/**
 * Class ManagerFactory
 *
 * @package coolfarmer\MailingConnectorBundle\Factory
 */
class ManagerFactory
{
    /**
     * Create campaign commander manager
     *
     * @param string $login
     * @param string $password
     * @param string $key
     * @param string $server
     *
     * @return CampaignCommanderManager
     */
    public static function createCampaignCommander($login, $password, $key, $server)
    {
        return new CampaignCommanderManager($login, $password, $key, $server);
    }

    /**
     * Create Sendinblue manager
     *
     * @param string $key
     * @param string $server
     *
     * @return SendinblueManager
     */
    public static function createSendinblue($key, $server)
    {
        return new SendinblueManager($key, $server);
    }
} 