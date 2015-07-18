<?php

namespace MailingConnector\Service;

use coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\CampaignCommanderManager;
use coolfarmer\MailingConnectorBundle\Service\NotificationService;
use coolfarmer\MailingConnectorBundle\Transactional\TransactionalEmail;
use coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Service\NotificationService as CCManagerNotificationService;

/**
 * Class NotificationServiceTest
 *
 * @package MailingConnector\Service
 */
class NotificationServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $manager;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $notificationServiceMock;

    
    /**
     * Setup
     */
    protected function setUp()
    {
        $notificationServiceMock = $this->getMockBuilder(CCManagerNotificationService::CLASS_NAME)
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->manager = $this->getMockBuilder(CampaignCommanderManager::CLASS_NAME)
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->notificationServiceMock = $notificationServiceMock;
    }

    public function testShouldCallSendMethodAndReturnTrue()
    {
        $transactionalEmailMock = $this->getMockBuilder(TransactionalEmail::CLASS_NAME)
            ->disableOriginalConstructor()
            ->getMock();

        $this->notificationServiceMock->expects($this->once())
            ->method('send')
            ->with($transactionalEmailMock)
            ->willReturn(true);

        $this->manager->expects($this->once())
            ->method('getNotificationService')
            ->willReturn($this->notificationServiceMock);

        $abstractNotificationService = new NotificationService($this->manager);
        $response = $abstractNotificationService->send($transactionalEmailMock);

        $this->assertTrue($response);
    }
} 