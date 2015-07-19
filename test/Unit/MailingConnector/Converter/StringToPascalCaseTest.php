<?php

namespace MailingConnector\Converter;

use coolfarmer\MailingConnectorBundle\Converter\StringToPascalCase;

/**
 * Class StringToPascalCaseTest
 *
 * @package MailingConnector\Converter
 */
class StringToPascalCaseTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldConvertStringToPascalCase()
    {
        $pascalCaseConverter = new StringToPascalCase();
        $converted = $pascalCaseConverter->convert('pascal_case');
        $this->assertSame('PascalCase', $converted);
    }
    
    /**
     * @expectedException \Exception
     * @expectedExceptionMessage String cannot be empty.
     */
    public function testStringToConvertIsNotEmpty()
    {
        $pascalCaseConverter = new StringToPascalCase();
        $pascalCaseConverter->convert('');
    }
} 