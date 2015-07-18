<?php

namespace coolfarmer\MailingConnectorBundle\Member;

use coolfarmer\MailingConnectorBundle\Member\Enum\EnumMemberCustomField;

/**
 * Class Member
 * 
 * Here is the basic and custom information about a subscriber.
 *
 * @package coolfarmer\MailingConnectorBundle\Member
 */
class Member
{
    const CLASS_NAME = __CLASS__;

    /**
     * @var string
     */
    private $firstName;
    
    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $emailOrigin;

    /**
     * @var string
     */
    private $cellphone;

    /**
     * @var \DateTime
     */
    private $birthdayDate;

    /**
     * @var \DateTime
     */
    private $dateSubscribe;

    
    /*******************************
     * CUSTOM FIELDS
     ******************************/

    /**
     * @var string
     */
    private $country;

    /**
     * @var CustomFieldCollection
     */
    private $customFields;

    
    /**
     * @param string $email
     */
    public function __construct($email)
    {
        $this->email = $email;
        $this->dateSubscribe = new \DateTime();
        $this->customFields = new CustomFieldCollection();
    }

    /**
     * @param string $firstName
     *
     * @return $this
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $lastName
     *
     * @return $this
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $emailOrigin
     *
     * @return $this
     */
    public function setEmailOrigin($emailOrigin)
    {
        $this->emailOrigin = $emailOrigin;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmailOrigin()
    {
        return $this->emailOrigin;
    }

    /**
     * @param string $cellphone
     *
     * @return $this
     */
    public function setCellphone($cellphone)
    {
        $this->cellphone = $cellphone;

        return $this;
    }

    /**
     * @return string
     */
    public function getCellphone()
    {
        return $this->cellphone;
    }

    /**
     * @param \DateTime $birthdayDate
     *
     * @return $this
     */
    public function setBirthdayDate(\DateTime $birthdayDate)
    {
        $this->birthdayDate = $birthdayDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBirthdayDate()
    {
        return $this->birthdayDate;
    }

    /**
     * @param \DateTime $dateSubscribe
     *
     * @return $this
     */
    public function setDateSubscribe(\DateTime $dateSubscribe)
    {
        $this->dateSubscribe = $dateSubscribe;
        
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateSubscribe()
    {
        return $this->dateSubscribe;
    }

    /**
     * @param string $country
     *
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = $country;
        $this->addCustomField(EnumMemberCustomField::COUNTRY, $country);

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return CustomFieldCollection
     */
    public function getCustomFields()
    {
        return $this->customFields;
    }
    
    /**
     * Add custom field
     *
     * @param string $field  Choose a constant from EnumCustomField class
     * @param mixed $value  Some value
     *
     * @return $this
     */
    private function addCustomField($field, $value)
    {
        if (in_array($field, EnumMemberCustomField::getSupportedValues())) {
            $this->customFields->addCustomFieldByKeyValue($field, $value);
        }

        return $this;
    }
} 