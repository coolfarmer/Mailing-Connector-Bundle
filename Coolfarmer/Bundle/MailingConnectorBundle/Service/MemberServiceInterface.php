<?php

namespace coolfarmer\MailingConnectorBundle\Service;

use coolfarmer\MailingConnectorBundle\Member\Member;

/**
 * Interface MemberServiceInterface
 *
 * @package coolfarmer\MailingConnectorBundle\Service
 */
interface MemberServiceInterface
{
    /**
     * @param Member $member
     */
    public function subscribe(Member $member);

    /**
     * @param Member $member
     */
    public function update(Member $member);

    /**
     * @param string $email
     */
    public function unsubscribe($email);

    /**
     * @param string $email
     *
     * @return Member
     */
    public function findByEmail($email);
} 