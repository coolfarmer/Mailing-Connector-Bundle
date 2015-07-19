<?php

namespace MailingConnector\Manager\CampaignCommander;

use coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\CampaignCommanderManager;
use coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Service\MemberService as CCManagerMemberService;
use coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Service\NotificationService as CCManagerNotificationService;
use coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Service\BatchMemberService as CCManagerBatchMemberService;

/**
 * Class CampaignCommanderManagerTest
 *
 * @package MailingConnector\Manager\CampaignCommander
 */
class CampaignCommanderManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $standardClientFactory;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $standardNoAuthClientFactory;

    /**
     * @var \BeSimple\SoapClient\SoapClient
     */
    private $soapClient;

    
    /**
     * Setup
     */
    protected function setUp()
    {
        $standardClientFactory = $this->getMockBuilder('MyLittle\CampaignCommander\API\SOAP\StandardClientFactory')
            ->disableOriginalConstructor()
            ->getMock();

        $standardNoAuthClientFactory = $this->getMockBuilder('MyLittle\CampaignCommander\API\SOAP\StandardNoAuthClientFactory')
            ->disableOriginalConstructor()
            ->getMock();

        $soapClient = $this->getMockBuilder('\BeSimple\SoapClient\SoapClient')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->soapClient = $soapClient;
        $this->standardClientFactory = $standardClientFactory;
        $this->standardNoAuthClientFactory = $standardNoAuthClientFactory;
    }
    
    public function testShouldGetMemberService()
    {
        $this->standardClientFactory->expects($this->once())
            ->method('createClient')
            ->willReturn($this->soapClient);

        $ccManager = new CampaignCommanderManager($this->standardClientFactory, $this->standardNoAuthClientFactory);
        
        $memberService = $ccManager->getMemberService();
        $this->assertInstanceOf(CCManagerMemberService::CLASS_NAME, $memberService);
    }
    
    public function testShouldGetNotificationService()
    {
        $this->standardNoAuthClientFactory->expects($this->once())
            ->method('createClient')
            ->willReturn($this->soapClient);
        
        $ccManager = new CampaignCommanderManager($this->standardClientFactory, $this->standardNoAuthClientFactory);
        
        $notificationService = $ccManager->getNotificationService();
        $this->assertInstanceOf(CCManagerNotificationService::CLASS_NAME, $notificationService);
    }

    public function testShouldGetImportMemberService()
    {
        $this->standardClientFactory->expects($this->once())
            ->method('createClient')
            ->willReturn($this->soapClient);

        $ccManager = new CampaignCommanderManager($this->standardClientFactory, $this->standardNoAuthClientFactory);
        
        $importMemberService = $ccManager->getImportMemberService();
        $this->assertInstanceOf(CCManagerBatchMemberService::CLASS_NAME, $importMemberService);
    }
} 