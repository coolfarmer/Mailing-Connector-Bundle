<?php

namespace coolfarmer\MailingConnectorBundle\Service;

use coolfarmer\MailingConnectorBundle\Member\Member;
use coolfarmer\MailingConnectorBundle\Manager\Manager;

/**
 * Class MemberService
 *
 * This service allows to access your members’ profile through the Manager API.
 * Allowing you to insert, update, and get a member profile.
 * 
 * @package coolfarmer\MailingConnectorBundle\Service
 */
class MemberService implements MemberServiceInterface
{
    const CLASS_NAME = __CLASS__;

    /**
     * @var Manager
     */
    private $manager;

    
    /**
     * @param Manager $manager
     */
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }
    
    /**
     * Subscribe member
     * 
     * @param Member $member
     */
    public function subscribe(Member $member)
    {
        $this->manager->getMemberService()->subscribe($member);
    }

    /**
     * Update member
     * 
     * @param Member $member
     */
    public function update(Member $member)
    {
        $this->manager->getMemberService()->update($member);
    }

    /**
     * Unsubscribe member
     *
     * @param string $email
     *
     * @throws \Exception
     */
    public function unsubscribe($email)
    {
        if (empty($email)) {
            throw new \Exception('Member email is required.');
        }
        
        $this->manager->getMemberService()->unsubscribe($email);
    }

    /**
     * Find a member profile by email
     *
     * @param string $email
     *
     * @return Member
     * @throws \Exception
     */
    public function findByEmail($email)
    {
        if (empty($email)) {
            throw new \Exception('Member email is required.');
        }
        
        return $this->manager->getMemberService()->findByEmail($email);
    }
} 