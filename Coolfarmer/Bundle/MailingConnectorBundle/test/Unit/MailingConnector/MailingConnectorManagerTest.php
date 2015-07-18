<?php

namespace MailingConnector;

use coolfarmer\MailingConnectorBundle\MailingConnectorManager;
use coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\CampaignCommanderManager;
use coolfarmer\MailingConnectorBundle\Member\Member;
use coolfarmer\MailingConnectorBundle\Service\ImportMemberService;
use coolfarmer\MailingConnectorBundle\Service\MemberService;
use coolfarmer\MailingConnectorBundle\Service\NotificationService;

/**
 * Class MailingConnectorManagerTest
 *
 * @package MailingConnector
 */
class MailingConnectorManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MailingConnectorManager
     */
    private $mailingConnectorManager;
    
    
    /**
     * Setup
     */
    public function setUp()
    {
        $manager = $this->getMockBuilder(CampaignCommanderManager::CLASS_NAME)
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->mailingConnectorManager = new MailingConnectorManager($manager);
    }
    
    public function testShouldCreateMember()
    {
        $member = $this->mailingConnectorManager->createNewMember('test@domain.com');
        $this->assertInstanceOf(Member::CLASS_NAME, $member);
    }
    
    public function testShouldGetMemberService()
    {
        $memberService = $this->mailingConnectorManager->getMemberService(); 
        $this->assertInstanceOf(MemberService::CLASS_NAME, $memberService);
    }
    
    public function testShouldGetNotificationService()
    {
        $notificationService = $this->mailingConnectorManager->getNotificationService();
        $this->assertInstanceOf(NotificationService::CLASS_NAME, $notificationService);
    }

    public function testShouldGetMemberImportService()
    {
        $importMemberService = $this->mailingConnectorManager->getImportMemberService();
        $this->assertInstanceOf(ImportMemberService::CLASS_NAME, $importMemberService);
    }
} 