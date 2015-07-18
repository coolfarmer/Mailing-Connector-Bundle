<?php

namespace coolfarmer\MailingConnectorBundle;

use coolfarmer\MailingConnectorBundle\Factory\MemberFactory;
use coolfarmer\MailingConnectorBundle\Manager\Manager;
use coolfarmer\MailingConnectorBundle\Service\ImportMemberService;
use coolfarmer\MailingConnectorBundle\Service\ImportMemberServiceInterface;
use coolfarmer\MailingConnectorBundle\Service\MemberService;
use coolfarmer\MailingConnectorBundle\Service\MemberServiceInterface;
use coolfarmer\MailingConnectorBundle\Service\NotificationService;
use coolfarmer\MailingConnectorBundle\Service\NotificationServiceInterface;

/**
 * Class MailingConnectorManager
 *
 * @package coolfarmer\MailingConnectorBundle
 */
class MailingConnectorManager
{
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
     * Create new member
     * 
     * @param $email
     *
     * @return Member\Member
     */
    public function createNewMember($email)
    {
        return MemberFactory::create($email);
    }

    /**
     * @return MemberServiceInterface
     */
    public function getMemberService()
    {
        return new MemberService($this->manager);
    }

    /**
     * @return NotificationServiceInterface
     */
    public function getNotificationService()
    {
        return new NotificationService($this->manager);
    }

    /**
     * @return ImportMemberServiceInterface
     */
    public function getImportMemberService()
    {
        return new ImportMemberService($this->manager);
    }
} 