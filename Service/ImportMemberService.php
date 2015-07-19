<?php

namespace coolfarmer\MailingConnectorBundle\Service;

use coolfarmer\MailingConnectorBundle\Manager\Manager;
use coolfarmer\MailingConnectorBundle\Member\MemberFileImport;

/**
 * Class NotificationService
 *
 * This service allows you import a batch of members.
 * 
 * @package coolfarmer\MailingConnectorBundle\Service
 */
class ImportMemberService implements ImportMemberServiceInterface
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
     * Upload a file that contain a batch of members
     * 
     * @param MemberFileImport $memberFileImport
     */
    public function uploadFile(MemberFileImport $memberFileImport)
    {
        $this->manager->getImportMemberService()->uploadFile($memberFileImport);
    }
} 