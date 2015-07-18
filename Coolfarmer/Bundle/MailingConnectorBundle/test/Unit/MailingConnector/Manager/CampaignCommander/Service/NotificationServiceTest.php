<?php

namespace MailingConnector\Manager\CampaignCommander\Service;

use coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Service\NotificationService as CCManagerNotificationService;
use coolfarmer\MailingConnectorBundle\Parameter\ParameterCollection;
use coolfarmer\MailingConnectorBundle\Transactional\Recipient\RecipientCollection;
use coolfarmer\MailingConnectorBundle\Transactional\TransactionalEmail;

/**
 * Class NotificationServiceTest
 *
 * @package MailingConnector\Manager\CampaignCommander\Service
 */
class NotificationServiceTest extends \PHPUnit_Framework_TestCase
{
    const CAMPAIGN_COMMANDER_ABSTRACT_SERVICE = 'MyLittle\CampaignCommander\Service\NotificationService';

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $CCNotificationServiceMock;


    /**
     * Setup
     */
    public function setUp()
    {
        $CCNotificationServiceMock = $this->getMockBuilder(self::CAMPAIGN_COMMANDER_ABSTRACT_SERVICE)
            ->disableOriginalConstructor()
            ->getMock();

        $this->CCNotificationServiceMock = $CCNotificationServiceMock;
    }
    
    public function testShouldSendTransactionalEmailAndReturnTrue()
    {
        $this->CCNotificationServiceMock->expects($this->once())
            ->method('sendObject');
        
        $service = new CCManagerNotificationService($this->CCNotificationServiceMock);

        $transactionalEmailMock = $this->getMockBuilder(TransactionalEmail::CLASS_NAME)
            ->disableOriginalConstructor()
            ->getMock();
        
        $parameterCollection = new ParameterCollection();
        $parameterCollection->addParameterByKeyValue('encrypt', 'abc123');
        $parameterCollection->addParameterByKeyValue('random', '1234567890');
        
        $recipientCollection = new RecipientCollection();
        $recipientCollection->addRecipientByValue('test@domain.com');

        $attributesCollection = new ParameterCollection();

        $transactionalEmailMock->expects($this->atLeastOnce())
            ->method('getOptions')
            ->willReturn($parameterCollection);

        $transactionalEmailMock->expects($this->atLeastOnce())
            ->method('getRecipients')
            ->willReturn($recipientCollection);

        $transactionalEmailMock->expects($this->atLeastOnce())
            ->method('getAttributes')
            ->willReturn($attributesCollection);
        
        $service->send($transactionalEmailMock);
    }
} 