<?php

namespace MailingConnector\Factory;

use coolfarmer\MailingConnectorBundle\Factory\MemberFactory;
use coolfarmer\MailingConnectorBundle\Member\Member;

/**
 * Class MemberFactoryTest
 *
 * @package MailingConnector\Factory
 * @author  Olivier Beauchemin <obeauchemin@crakmedia.com>
 */
class MemberFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldCreateMember()
    {
        $member = MemberFactory::create('test@domain.com');
        $this->assertInstanceOf(Member::CLASS_NAME, $member);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Member must have at least an email.
     */
    public function testShouldThrowExceptionIfEmailIsEmpty()
    {
        MemberFactory::create('');
    }
} 