<?php

namespace coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Service;

use coolfarmer\MailingConnectorBundle\Converter\StringToPascalCase;
use coolfarmer\MailingConnectorBundle\Factory\MemberFactory;
use coolfarmer\MailingConnectorBundle\Member\Enum\EnumMemberField;
use coolfarmer\MailingConnectorBundle\Member\Enum\EnumMemberCustomField;
use coolfarmer\MailingConnectorBundle\Member\Member;
use coolfarmer\MailingConnectorBundle\Service\MemberServiceInterface;
use MyLittle\CampaignCommander\API\SOAP\ClientFactoryInterface;
use MyLittle\CampaignCommander\Service\MemberService as CCMemberService;

/**
 * Class MemberService
 * 
 * This API allows to access your members’ profile through the API. It provides access to the MEMBER table 
 * allowing you to insert, update, and get a member profile. The member table is a single table stored in 
 * SmartFocus' datacenter. 
 * 
 * It contains all the profile information of your recipients, such as email address, first name, last name, 
 * and any column defined during the life of your account.
 *
 * @package  coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Service
 */
class MemberService implements MemberServiceInterface
{
    const CLASS_NAME = __CLASS__;

    /**
     * @var CCMemberService
     */
    private $service; 


    /**
     * @param ClientFactoryInterface $client
     */
    public function __construct(ClientFactoryInterface $client)
    {
        $this->service = new CCMemberService($client);
    }

    /**
     * Subscribe member
     *
     * @param Member $member
     *
     * @throws \Exception
     */
    public function subscribe(Member $member)
    {
        $data = array();
        $supportedValues = array_merge(
            EnumMemberField::getSupportedValues(),
            EnumMemberCustomField::getSupportedValues()
        );
        
        foreach ($supportedValues as $fieldName) {
            $getter = 'get' . StringToPascalCase::convert(strtolower($fieldName));
            if (!method_exists($member, $getter)) {
                throw new \Exception('Call to undefined method : \'' . $getter . '\'()');
            }
            $value = $member->$getter();
            if (in_array($fieldName, EnumMemberField::getMandatoryValues()) && null === $value) {
                throw new \Exception('Value cannot be null. Parameter name: ' . $fieldName);
            }
            if ($value instanceof \DateTime) {
                $value = $value->format('Y-m-d H:i:s');
            }
            
            $data[$fieldName] = $value;
        }
        
        $this->service->insertOrUpdateMemberByObj($data, $member->getEmail());
    }

    /**
     * Update member
     * 
     * This use the same logic of MemberService::subscribe because 
     * MemberService::subscribe use 'insertOrUpdateMemberByObj'
     * 
     * @param Member $member
     */
    public function update(Member $member)
    {
        $this->subscribe($member);
    }

    /**
     * Unsubscribe member
     * 
     * @param string $email  The email address of the member to unsubscribe.
     *
     * @throws \Exception
     */
    public function unsubscribe($email)
    {
        if (empty($email)) {
            throw new \Exception('Member email is required.');
        }
        
        $this->service->unjoinMemberByEmail($email);
    }

    /**
     * @param string $email  The email address of the member to retrieve.
     *
     * @return Member
     * @throws \Exception
     */
    public function findByEmail($email)
    {
        if (empty($email)) {
            throw new \Exception('Member email is required.');
        }
        
        $response = $this->service->getMemberByEmail($email);
        $member = $this->memberHandleResponse($response);
        
        return $member;
    }

    /**
     * Handle response of user profile search to return an abstract Member object
     *
     * @param array $response
     *
     * @return Member
     */
    private function memberHandleResponse(array $response)
    {
        $member = MemberFactory::create($response['EMAIL']);
        $member
            ->setFirstName($response['FIRSTNAME'])
            ->setLastName($response['LASTNAME'])
            ->setEmailOrigin($response['EMAIL_ORIGINE'])
            ->setCellphone($response['EMVCELLPHONE']);
        
        if (null !== $response['DATEOFBIRTH']) {
            $member->setBirthdayDate(new \DateTime($response['DATEOFBIRTH']));
        }
        if (null !== $response['DATE_SUBSCRIBE']) {
            $member->setDateSubscribe(new \DateTime($response['DATE_SUBSCRIBE']));
        }
        
        // Handle custom fields
        $responseFieldAvailable = array_keys($response);
        foreach (EnumMemberCustomField::getSupportedValues() as $fieldName) {
            if (in_array($fieldName, $responseFieldAvailable)) {
                $setter = 'set' . StringToPascalCase::convert(strtolower($fieldName));
                if (!method_exists($member, $setter)) {
                    continue;
                }
                $value = $response[$fieldName];
                if (null === $value) {
                    continue;
                }
                $member->$setter($value);
            }
        }
        
        return $member;
    }
} 