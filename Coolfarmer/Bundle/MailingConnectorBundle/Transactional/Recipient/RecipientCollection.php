<?php

namespace coolfarmer\MailingConnectorBundle\Transactional\Recipient;

use Star\Component\Collection\TypedCollection;

/**
 * Class RecipientCollection
 *
 * @package coolfarmer\MailingConnectorBundle\Transactional\Recipient
 */
class RecipientCollection
{
    const CLASS_NAME = __CLASS__;

    /**
     * @var Recipient[]
     */
    private $collection;


    public function __construct()
    {
        $this->collection = new TypedCollection(Recipient::CLASS_NAME);
    }

    /**
     * @param Recipient $recipient
     *
     * @return bool
     */
    public function addRecipient(Recipient $recipient)
    {
        $existingKey = $this->contain($recipient);

        if (false !== $existingKey) {
            $this->updateRecipient($existingKey, $recipient->getValue());

            return true;
        }

        $this->collection->add($recipient);

        return true;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function addRecipientByValue($value)
    {
        $recipient = new Recipient($value);
        $existingKey = $this->contain($recipient);

        if (false !== $existingKey) {
            $this->updateRecipient($existingKey, $value);

            return true;
        }

        $this->collection->add($recipient);

        return true;
    }

    /**
     * @param int $collectionKey
     * @param string $value
     */
    public function updateRecipient($collectionKey, $value)
    {
        $recipient = $this->get($collectionKey);
        $recipient->setValue($value);
        $this->collection->set($collectionKey, $recipient);
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
     * Checks whether a parameter is contained in the collection.
     *
     * @param Recipient $recipient
     *
     * @return boolean TRUE if the collection contains the element, FALSE otherwise.
     */
    public function contain(Recipient $recipient)
    {
        /** @var Recipient $item */
        foreach ($this->collection->toArray() as $idx => $item) {
            if ($recipient->getValue() == $item->getValue()) {
                return $idx;
            }
        }

        return false;
    }

    /**
     * @return RecipientCollection
     */
    public function toArray()
    {
        return $this->collection->toArray();
    }
} 