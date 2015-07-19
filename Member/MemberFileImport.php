<?php

namespace coolfarmer\MailingConnectorBundle\Member;

use coolfarmer\MailingConnectorBundle\Parameter\ParameterCollection;

/**
 * Class MemberFileImport
 *
 * @package coolfarmer\MailingConnectorBundle\Member
 */
class MemberFileImport
{
    const CLASS_NAME = __CLASS__;

    /**
     * The name of the file to upload (filename + extension)
     * 
     * @var string
     */
    private $fileName;

    /**
     * The encoding of the file (ex.: UTF-8)
     * 
     * @var string
     */
    private $fileEncoding;
    
    /**
     * @var string
     */
    private $separator;

    /**
     * @var string
     */
    private $url;

    /**
     * @var ParameterCollection
     */
    private $options;

    
    /**
     * @param string $fileName
     */
    public function __construct($fileName)
    {
        $this->fileName = $fileName;
        $this->options = new ParameterCollection();
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param string $fileEncoding
     *
     * @return $this
     */
    public function setFileEncoding($fileEncoding)
    {
        $this->fileEncoding = $fileEncoding;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getFileEncoding()
    {
        return $this->fileEncoding;
    }

    /**
     * @param string $separator
     *
     * @return $this
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getSeparator()
    {
        return $this->separator;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Add an option
     * 
     * @param string $key
     * @param string $value
     *
     * @return $this
     */
    public function addOption($key, $value)
    {
        $this->options->addParameterByKeyValue($key, $value);

        return $this;
    }

    /**
     * @return ParameterCollection
     */
    public function getOptions()
    {
        return $this->options;
    }
} 