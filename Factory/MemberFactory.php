<?php

namespace coolfarmer\MailingConnectorBundle\Factory;

use coolfarmer\MailingConnectorBundle\Member\Member;

/**
 * Class MemberFactory
 *
 * @package coolfarmer\MailingConnectorBundle\Factory
 */
class MemberFactory
{
    /**
     * Create Member
     *
     * @param string $email
     *
     * @throws \Exception
     * @return Member
     */
    public static function create($email)
    {
        if (empty($email)) {
            throw new \Exception('Member must have at least an email.');
        }
        
        $member = new Member($email);
        
        return $member;
    }
} 