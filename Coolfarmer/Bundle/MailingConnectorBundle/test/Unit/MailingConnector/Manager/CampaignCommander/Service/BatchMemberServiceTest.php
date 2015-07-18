<?php

namespace MailingConnector\Manager\CampaignCommander\Service;

use coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\BatchMember\ColumnCollection;
use coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Service\BatchMemberService as CCManagerBatchMemberService;
use coolfarmer\MailingConnectorBundle\Member\MemberFileImport;
use coolfarmer\MailingConnectorBundle\Parameter\ParameterCollection;

/**
 * Class BatchMemberServiceTest
 *
 * @package MailingConnector\Manager\CampaignCommander\Service
 */
class BatchMemberServiceTest extends \PHPUnit_Framework_TestCase
{
    const CAMPAIGN_COMMANDER_ABSTRACT_SERVICE = 'MyLittle\CampaignCommander\Service\BatchMemberService';

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $CCBatchMemberServiceMock;


    /**
     * Setup
     */
    public function setUp()
    {
        $CCBatchMemberServiceMock = $this->getMockBuilder(self::CAMPAIGN_COMMANDER_ABSTRACT_SERVICE)
            ->disableOriginalConstructor()
            ->getMock();

        $this->CCBatchMemberServiceMock = $CCBatchMemberServiceMock;
    }
    
    public function testShouldUploadFileAndReturnTrue()
    {
        $this->CCBatchMemberServiceMock->expects($this->once())
            ->method('uploadFileMerge');
        
        $service = new CCManagerBatchMemberService($this->CCBatchMemberServiceMock);

        $memberImportFileMock = $this->getMockBuilder(MemberFileImport::CLASS_NAME)
            ->disableOriginalConstructor()
            ->getMock();
        
        $columnCollection = $this->getMock(ColumnCollection::CLASS_NAME);
        $columnCollection->expects($this->atLeastOnce())
            ->method('toArray')
            ->willReturn(array());
        
        $mappingMock = $this->getMock(Mapping::CLASS_NAME);
        $mappingMock->expects($this->once())
            ->method('getColumns')
            ->willReturn($columnCollection);
        
        $parameterCollection = new ParameterCollection();
        $parameterCollection->addParameterByKeyValue('file', 'abc123');
        $parameterCollection->addParameterByKeyValue('criteria', 'LOWER(EMAIL)');
        $parameterCollection->addParameterByKeyValue('dateFormat', 'YYYY-mm-dd');
        $parameterCollection->addParameterByKeyValue('skipFirstLine', true);
        $parameterCollection->addParameterByKeyValue('mapping', $mappingMock);

        $memberImportFileMock->expects($this->atLeastOnce())
            ->method('getOptions')
            ->willReturn($parameterCollection);
        
        $service->uploadFile($memberImportFileMock);
    }
} 