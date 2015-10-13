<?php

namespace coolfarmer\MailingConnectorBundle\Manager\Sendinblue\Service;

use coolfarmer\MailingConnectorBundle\Converter\StringToPascalCase;
use coolfarmer\MailingConnectorBundle\Factory\MemberFactory;
use coolfarmer\MailingConnectorBundle\Member\Enum\EnumMemberCustomField;
use coolfarmer\MailingConnectorBundle\Member\Enum\EnumMemberField;
use coolfarmer\MailingConnectorBundle\Member\Member;
use coolfarmer\MailingConnectorBundle\Service\MemberServiceInterface;
use Sendinblue\Mailin;

/**
 * Class MemberService
 *
 * @package coolfarmer\MailingConnectorBundle\Manager\Sendinblue
 */
class MemberService implements MemberServiceInterface
{
    /**
     * @var Mailin
     */
    private $service;


    /**
     * @param Mailin $api
     */
    public function __construct(Mailin $api)
    {
        $this->service = $api;
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
        $attributes = array();
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

            $attributes[$fieldName] = $value;
        }

        $this->service->create_update_user(
            array(
                'email' => $member->getEmail(),
                'attributes' => $attributes,
                'blacklisted' => 0,
                'listid' => array(),
                'listid_unlink' => array(),
                'blacklisted_sms' => 0,
            )
        );
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
        // Delete user from all list
        $this->service->delete_user($email);

        // Blacklist user
        $this->service->create_update_user(
            array(
                'email' => $email,
                'attributes' => array(),
                'blacklisted' => 1,
                'listid' => array(),
                'listid_unlink' => array(),
                'blacklisted_sms' => 1,
            )
        );
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

        $response = $this->service->get_user($email);
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
        $member = MemberFactory::create($response['data']['email']);
        $member
            ->setFirstName($response['data']['attributes']['FIRSTNAME'])
            ->setLastName($response['data']['attributes']['LASTNAME']);

        if (null !== $response['data']['entered']) {
            $member->setDateSubscribe(new \DateTime($response['data']['entered']));
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