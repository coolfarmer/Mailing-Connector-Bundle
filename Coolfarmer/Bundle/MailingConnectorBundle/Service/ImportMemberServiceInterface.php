<?php

namespace coolfarmer\MailingConnectorBundle\Service;

use coolfarmer\MailingConnectorBundle\Member\MemberFileImport;

/**
 * Interface ImportMemberServiceInterface
 *
 * @package coolfarmer\MailingConnectorBundle\Service
 */
interface ImportMemberServiceInterface
{
    /**
     * @param MemberFileImport $memberFileImport
     */
    public function uploadFile(MemberFileImport $memberFileImport);
} 