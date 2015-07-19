<?php

namespace coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Service;

use coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\BatchMember\Column;
use coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\BatchMember\Mapping;
use coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Member\Enum\EnumMemberFileImportOption;
use coolfarmer\MailingConnectorBundle\Member\MemberFileImport;
use coolfarmer\MailingConnectorBundle\Service\ImportMemberServiceInterface;
use MyLittle\CampaignCommander\API\SOAP\ClientFactoryInterface;
use MyLittle\CampaignCommander\Service\BatchMemberService as CCBatchMemberService;

/**
 * Class BatchMemberService
 * 
 * This service allows you to create and update your customers’ profiles in your SmartFocus member table. 
 * This API offers you a seamless way to insert or merge a file of members through one single API call whenever 
 * you want and with the member fields you desire. You can upload up to 5 files at a time, each with a maximum 
 * size of 256 MB. The member table is a single table stored in SmartFocus’ datacenter. 
 * 
 * It contains all the profile information of your recipients, such as email address, first name, last name, 
 * and any column defined during the life of your account.
 *
 * @package coolfarmer\MailingConnectorBundle\Manager\CampaignCommander\Service
 */
class BatchMemberService implements ImportMemberServiceInterface
{
    const CLASS_NAME = __CLASS__;

    const ENCODING_DEFAULT = 'UTF-8';
    const DATEFORMAT_DEFAULT = 'dd/mm/yyyy';
    const SEPARATOR_DEFAULT = ';';
    const CRITERIA_DEFAULT = 'LOWER(EMAIL)';
    const SKIPFIRSTLINE_DEFAULT = true;
    
    /**
     * @var CCBatchMemberService
     */
    private $service;


    /**
     * @param ClientFactoryInterface $client
     */
    public function __construct(ClientFactoryInterface $client)
    {
        $this->service = new CCBatchMemberService($client);
    }

    /**
     * Upload a file that contain a batch of members
     * 
     * @param MemberFileImport $memberFileImport
     *
     * @throws \Exception
     */
    public function uploadFile(MemberFileImport $memberFileImport)
    {
        $this->uploadFileCheckSupportedOptions($memberFileImport);
        $this->uploadFileCheckMandatoryOptions($memberFileImport);
        
        $options = $memberFileImport->getOptions();
        $fileContent = $options->getParameterByName('file');
        $criteria = $options->getParameterByName('criteria');
        $dateFormat = $options->getParameterByName('dateFormat');
        $skipFirstLine = $options->getParameterByName('skipFirstLine');
        $mapping = $options->getParameterByName('mapping');
        $fileEncoding = $memberFileImport->getFileEncoding();
        $separator = $memberFileImport->getSeparator();
        
        if (null === $criteria) {
            $criteria = self::CRITERIA_DEFAULT;
        }
        if (null === $fileEncoding) {
            $fileEncoding = self::ENCODING_DEFAULT;
        }
        if (null === $separator) {
            $separator = self::SEPARATOR_DEFAULT;
        }
        if (null === $dateFormat) {
            $dateFormat = self::DATEFORMAT_DEFAULT;
        }
        if (null === $skipFirstLine) {
            $skipFirstLine = self::SKIPFIRSTLINE_DEFAULT;
        }
        if (null !== $mapping) {
            $mapping = $mapping->getValue();
        } else {
            // Auto-mapping
            $mapping = $this->autoMapColumn($fileContent->getValue(), $separator);
        }
        
        $this->service->uploadFileMerge(
            $fileContent->getValue(),
            $memberFileImport->getFileName(),
            $criteria,
            $this->handleMappingOption($mapping),
            $fileEncoding,
            $separator,
            $skipFirstLine,
            $dateFormat
        );
    }

    /**
     * Handle mapping option and return a correct formatted array for CampaignCommander
     *
     * @param Mapping $mapping
     *
     * @return array
     */
    private function handleMappingOption(Mapping $mapping)
    {
        $map = array();
        
        /** @var Column $column */
        foreach ($mapping->getColumns()->toArray() as $idx => $column) {
            $currentColumn = array();
            $currentColumn['colNum'] = ($idx + 1);
            $currentColumn['fieldName'] = $column->getFieldName();
            $currentColumn['toReplace'] = 'false';
            
            if (null !== $column->getDateFormat()) {
                $currentColumn['dateFormat'] = $column->getDateFormat();
            }
            if (null !== $column->getDefaultValue()) {
                $currentColumn['defaultValue'] = $column->getDefaultValue();
            }
            
            array_push($map, $currentColumn);
        }
        
        return $map;
    }

    /**
     * Auto-map columns
     * 
     * @param string $fileContent
     * @param string $separator
     *
     * @return Mapping
     */
    private function autoMapColumn($fileContent, $separator)
    {
        $firstFileRow = explode("\n", $fileContent);
        $firstFileRow = str_replace("\r", '', $firstFileRow[0]);
        $columns = explode($separator, $firstFileRow);

        $mapping = new Mapping();
        foreach ($columns as $column) {
            $mapping->addColumn($column);
        }
        
        return $mapping;
    }

    /**
     * Checking if mandatory options are there
     *
     * @param MemberFileImport $memberFileImport
     *
     * @throws \Exception
     */
    private function uploadFileCheckMandatoryOptions(MemberFileImport $memberFileImport)
    {
        $options = $memberFileImport->getOptions();
        foreach (EnumMemberFileImportOption::getMandatoryValues() as $option) {
            if (null === $options->getParameterByName($option)) {
                throw new \Exception(
                    'Import member : Required option (' . $option . ') was missing.'
                );
            }
        }
    }

    /**
     * Checking if we receive a not supported option
     *
     * @param MemberFileImport $memberFileImport
     *
     * @throws \Exception
     */
    private function uploadFileCheckSupportedOptions(MemberFileImport $memberFileImport)
    {
        $supportedValues = EnumMemberFileImportOption::getSupportedValues();
        foreach ($memberFileImport->getOptions() as $option) {
            if (!in_array($option, $supportedValues)) {
                throw new \Exception(
                    'Import member : This option (' . $option . ') is not supported by CampaignCommander.'
                );
            }
        }
    }
} 