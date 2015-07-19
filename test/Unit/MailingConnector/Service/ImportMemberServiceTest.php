<?php

namespace MailingConnector\Service;

use coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\CampaignCommanderManager;
use coolfarmer\MailingConnectorBundle\Member\MemberFileImport;
use coolfarmer\MailingConnectorBundle\Service\ImportMemberService;
use coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Service\BatchMemberService as CCManagerBatchMemberService;

/**
 * Class ImportMemberServiceTest
 *
 * @package MailingConnector\Service
 */
class ImportMemberServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $manager;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $importMemberServiceMock;

    
    /**
     * Setup
     */
    protected function setUp()
    {
        $importMemberServiceMock = $this->getMockBuilder(CCManagerBatchMemberService::CLASS_NAME)
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->manager = $this->getMockBuilder(CampaignCommanderManager::CLASS_NAME)
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->importMemberServiceMock = $importMemberServiceMock;
    }

    public function testShouldCallUploadFileMethodAndReturnTrue()
    {
        $memberFileImportMock = $this->getMockBuilder(MemberFileImport::CLASS_NAME)
            ->disableOriginalConstructor()
            ->getMock();

        $this->importMemberServiceMock->expects($this->once())
            ->method('uploadFile')
            ->with($memberFileImportMock)
            ->willReturn(true);

        $this->manager->expects($this->once())
            ->method('getImportMemberService')
            ->willReturn($this->importMemberServiceMock);

        $abstractNotificationService = new ImportMemberService($this->manager);
        $response = $abstractNotificationService->uploadFile($memberFileImportMock);

        $this->assertTrue($response);
    }
} 