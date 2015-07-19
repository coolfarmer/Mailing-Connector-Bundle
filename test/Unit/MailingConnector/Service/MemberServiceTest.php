<?php

namespace MailingConnector\Service;

use coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\CampaignCommanderManager;
use coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Service\MemberService as CCManagerMemberService;
use coolfarmer\MailingConnectorBundle\Member\Member;
use coolfarmer\MailingConnectorBundle\Service\MemberService;

/**
 * Class MemberServiceTest
 *
 * @package MailingConnector\Service
 */
class MemberServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $manager;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $memberServiceMock;

    
    /**
     * Setup
     */
    protected function setUp()
    {
        $memberServiceMock = $this->getMockBuilder(CCManagerMemberService::CLASS_NAME)
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->manager = $this->getMockBuilder(CampaignCommanderManager::CLASS_NAME)
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->memberServiceMock = $memberServiceMock;
    }
    
    public function testShouldCallSubscribeMethodAndReturnTrue()
    {
        $memberMock = $this->getMockBuilder(Member::CLASS_NAME)
            ->disableOriginalConstructor()
            ->getMock();

        $this->memberServiceMock->expects($this->once())
            ->method('subscribe')
            ->with($memberMock)
            ->willReturn(true);

        $this->manager->expects($this->once())
            ->method('getMemberService')
            ->willReturn($this->memberServiceMock);
        
        $abstractMemberService = new MemberService($this->manager);
        $response = $abstractMemberService->subscribe($memberMock);
        
        $this->assertTrue($response);
    }
    
    public function testShouldCallUpdateMethodAndReturnTrue()
    {
        $memberMock = $this->getMockBuilder(Member::CLASS_NAME)
            ->disableOriginalConstructor()
            ->getMock();

        $this->memberServiceMock->expects($this->once())
            ->method('update')
            ->with($memberMock)
            ->willReturn(true);

        $this->manager->expects($this->once())
            ->method('getMemberService')
            ->willReturn($this->memberServiceMock);

        $abstractMemberService = new MemberService($this->manager);
        $response = $abstractMemberService->update($memberMock);

        $this->assertTrue($response);
    }

    public function testShouldCallUnsubscribeMethodAndReturnTrue()
    {
        $this->memberServiceMock->expects($this->once())
            ->method('unsubscribe')
            ->with('test@domain.com')
            ->willReturn(true);

        $this->manager->expects($this->once())
            ->method('getMemberService')
            ->willReturn($this->memberServiceMock);

        $abstractMemberService = new MemberService($this->manager);
        $response = $abstractMemberService->unsubscribe('test@domain.com');

        $this->assertTrue($response);
    }
    
    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Member email is required.
     */
    public function testShouldCallUnsubscribeMethodAndThrowEmailIsNullException()
    {
        $abstractMemberService = new MemberService($this->manager);
        $abstractMemberService->unsubscribe(null);
    }

    public function testShouldCallFindByEmailMethodAndReturnMember()
    {
        $memberMock = $this->getMockBuilder(Member::CLASS_NAME)
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->memberServiceMock->expects($this->once())
            ->method('findByEmail')
            ->with($memberMock)
            ->willReturn($memberMock);

        $this->manager->expects($this->once())
            ->method('getMemberService')
            ->willReturn($this->memberServiceMock);

        $abstractMemberService = new MemberService($this->manager);
        $member = $abstractMemberService->findByEmail($memberMock);

        $this->assertInstanceOf(Member::CLASS_NAME, $member);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Member email is required.
     */
    public function testShouldCallFindByEmailMethodAndThrowEmailIsNullException()
    {
        $abstractMemberService = new MemberService($this->manager);
        $abstractMemberService->findByEmail(null);
    }
} 