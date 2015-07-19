<?php
    
namespace MailingConnector\Factory;

use coolfarmer\MailingConnectorBundle\Factory\ManagerFactory;
use coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\CampaignCommanderManager;

/**
 * Class ManagerFactoryTest
 *
 * @package MailingConnector\Factory
 * @author  Olivier Beauchemin <obeauchemin@crakmedia.com>
 */
class ManagerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldCreateCampaignCommanderManager()
    {
        $manager = ManagerFactory::createCampaignCommander('login', 'pass', 'key', 'server');
        $this->assertInstanceOf(CampaignCommanderManager::CLASS_NAME, $manager);
    }
} 