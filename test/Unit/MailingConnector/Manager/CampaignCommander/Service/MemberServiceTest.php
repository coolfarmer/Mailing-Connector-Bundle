<?php

namespace MailingConnector\Manager\CampaignCommander\Service;

use coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Service\MemberService as CCManagerMemberService;
use coolfarmer\MailingConnectorBundle\Member\Member;

/**
 * Class MemberServiceTest
 *
 * @package MailingConnector\Manager\CampaignCommander\Service
 */
class MemberServiceTest extends \PHPUnit_Framework_TestCase
{
    const CAMPAIGN_COMMANDER_ABSTRACT_SERVICE = 'MyLittle\CampaignCommander\Service\MemberService';
    
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $CCMemberServiceMock;
    
    
    /**
     * Setup
     */
    public function setUp()
    {
        $CCMemberServiceMock = $this->getMockBuilder(self::CAMPAIGN_COMMANDER_ABSTRACT_SERVICE)
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->CCMemberServiceMock = $CCMemberServiceMock;
    }
    
    public function testShouldSubscribeMemberAndReturnTrue()
    {
        $service = new CCManagerMemberService($this->CCMemberServiceMock);
        
        $memberMock = $this->getMockBuilder(Member::CLASS_NAME)
            ->setConstructorArgs(array('test@domain.com'))
            ->getMock();

        $memberMock->expects($this->atLeastOnce())
            ->method('getEmail')
            ->willReturn('test@domain.com');

        $response = $service->subscribe($memberMock);
        $this->assertTrue($response);
    }
    
    public function testShouldFormatDateInCampaignCommanderFormat()
    {
        $service = new CCManagerMemberService($this->CCMemberServiceMock);
        
        $dateTime = new \DateTime('2015-01-01');
        $formatted = $service->CCFormatDate($dateTime);
        
        $this->assertSame('2015-01-01 00:00:00', $formatted);
    }

    /**
     * @expectedException \Exception
     */
    public function testShouldThrowExceptionWhenNullValueIsGiven()
    {
        $service = new CCManagerMemberService($this->CCMemberServiceMock);
        
        $memberMock = $this->getMockBuilder(Member::CLASS_NAME)
            ->setConstructorArgs(array(null))
            ->getMock();

        $memberMock->expects($this->atLeastOnce())
            ->method('getEmail')
            ->willReturn(null);

        $service->subscribe($memberMock);
    }
    
    public function testShouldFindMemberAndReturnValidCampaignCommanderMember()
    {
        $this->CCMemberServiceMock->expects($this->once())
            ->method('getMemberByEmail')
            ->with('test@domain.com')
            ->willReturn(
                array(
                    'EMAIL' => 'test@domain.com',
                    'FIRSTNAME' => 'Olivier',
                    'LASTNAME' => 'Beauchemin',
                    'EMAIL_ORIGINE' => 'WebSiteUrl.com',
                    'EMVCELLPHONE' => '123-456-7890',
                )
            );

        $service = new CCManagerMemberService($this->CCMemberServiceMock);
        $member = $service->findByEmail('test@domain.com');
        
        $this->assertInstanceOf(Member::CLASS_NAME, $member);
        $this->assertSame('Olivier', $member->getFirstName());
        $this->assertSame('Beauchemin', $member->getLastName());
        $this->assertSame('test@domain.com', $member->getEmail());
        $this->assertSame('WebsiteUrl.com', $member->getEmailOrigin());
        $this->assertSame('123-456-7890', $member->getCellphone());
    }
    
    public function testShouldUnsubscribeMember()
    {
        $this->CCMemberServiceMock->expects($this->once())
            ->method('unjoinMemberByEmail')
            ->with('test@domain.com');

        $service = new CCManagerMemberService($this->CCMemberServiceMock);
        
        $response = $service->unsubscribe('test@domain.com');
        $this->assertTrue($response);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Member email is required.
     */
    public function testShouldThrowExceptionWhenEmailIsInvalidWhenAMemberIsUnsubscribe()
    {
        $service = new CCManagerMemberService($this->CCMemberServiceMock);
        $service->unsubscribe(null);
    }
    
    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Member email is required.
     */
    public function testShouldThrowExceptionWhenEmailIsInvalidWhenFindByEmailIsCalled()
    {
        $service = new CCManagerMemberService($this->CCMemberServiceMock);
        $service->findByEmail(null);
    }
} 