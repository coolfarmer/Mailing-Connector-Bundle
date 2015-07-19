<?php

namespace coolfarmer\MailingConnectorBundle\Parameter;

use Star\Component\Collection\TypedCollection;

/**
 * Class ParameterCollection
 *
 * @package coolfarmer\MailingConnectorBundle\Parameter
 */
class ParameterCollection
{
    const CLASS_NAME = __CLASS__;

    /**
     * @var Parameter[]
     */
    private $collection;

    
    public function __construct()
    {
        $this->collection = new TypedCollection(Parameter::CLASS_NAME);
    }

    /**
     * @param Parameter $parameter
     *
     * @return bool
     */
    public function addParameter(Parameter $parameter)
    {
        $existingKey = $this->contain($parameter);

        if (false !== $existingKey) {
            $this->updateParameter($existingKey, $parameter->getValue());

            return true;
        }
        
        $this->collection->add($parameter);
        
        return true;
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return bool
     */
    public function addParameterByKeyValue($key, $value)
    {
        $parameter = new Parameter($key, $value);
        $existingKey = $this->contain($parameter);

        if (false !== $existingKey) {
            $this->updateParameter($existingKey, $value);

            return true;
        }

        $this->collection->add($parameter);

        return true;
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
     * @return Parameter|null
     */
    public function getParameterByName($name)
    {
        $parameters = $this->collection->toArray();
        /** @var Parameter $parameter */
        foreach ($parameters as $parameter) {
            if ($parameter->getKey() == $name) {
                return $parameter;
            }
        }

        return null;
    }

    /**
     * Checks whether a parameter is contained in the collection.
     *
     * @param Parameter $parameter
     *
     * @return boolean TRUE if the collection contains the element, FALSE otherwise.
     */
    public function contain(Parameter $parameter)
    {
        /** @var Parameter $item */
        foreach ($this->collection->toArray() as $idx => $item) {
            if ($parameter->getKey() == $item->getKey()) {
                return $idx;
            }
        }

        return false;
    }

    /**
     * @return ParameterCollection
     */
    public function toArray()
    {
        return $this->collection->toArray();
    }
} 