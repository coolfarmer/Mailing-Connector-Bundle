<?php

namespace coolfarmer\MailingConnectorBundle\Member;

use Star\Component\Collection\TypedCollection;

/**
 * Class CustomFieldCollection
 *
 * @package coolfarmer\MailingConnectorBundle\Member
 */
class CustomFieldCollection
{
    const CLASS_NAME = __CLASS__;

    /**
     * @var CustomField[]
     */
    private $collection;


    public function __construct()
    {
        $this->collection = new TypedCollection(CustomField::CLASS_NAME);
    }

    /**
     * @param int $collectionKey
     * @param mixed $value
     */
    public function updateParameter($collectionKey, $value)
    {
        $parameter = $this->get($collectionKey);
        $parameter->setValue($value);
        $this->collection->set($collectionKey, $parameter);
    }

    /**
     * Gets the element at the specified key/index.
     *
     * @param int $key The key/index of the element to retrieve.
     *
     * @return mixed
     */
    public function get($key)
    {
        return $this->collection->get($key);
    }

    /**
     * @param string $name
     *
     * @return null|CustomField
     */
    public function getByName($name)
    {
        $customFields = $this->collection->toArray();
        /** @var CustomField $customField */
        foreach ($customFields as $customField) {
            if ($customField->getField() == $name) {
                return $customField;
            }
        }

        return null;
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return bool
     */
    public function addCustomFieldByKeyValue($key, $value)
    {
        $parameter = new CustomField($key, $value);
        $existingKey = $this->contain($parameter);

        if (false !== $existingKey) {
            $this->updateParameter($existingKey, $value);

            return true;
        }

        $this->collection->add($parameter);

        return true;
    }

    /**
     * Checks whether a field is contained in the collection.
     *
     * @param CustomField $customField
     * 
     * @return boolean TRUE if the collection contains the element, FALSE otherwise.
     */
    public function contain(CustomField $customField)
    {
        /** @var CustomField $item */
        foreach ($this->collection->toArray() as $idx => $item) {
            if ($customField->getField() == $item->getField()) {
                return $idx;
            }
        }

        return false;
    }

    /**
     * @return CustomFieldCollection
     */
    public function toArray()
    {
        return $this->collection->toArray();
    }
}