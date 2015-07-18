<?php

namespace coolfarmer\MailingConnectorBundle\DependencyInjection\Compiler;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class MailingConnectorPass
 *
 * @package coolfarmer\MailingConnectorBundle\DependencyInjection\Compiler
 */
class MailingConnectorPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        // Modify first argument of mailing_connector service
        $container->getDefinition('mailing_connector')
            ->setArguments(array($this->getDefaultMailingConnector($container)));
    }

    /**
     * Get the default mailing api
     *
     * @param ContainerBuilder $container
     *
     * @return Definition
     */
    public function getDefaultMailingConnector(ContainerBuilder $container)
    {
        $defaultMailingConnector = null;

        /**
         * SendinBlue API
         */
        if ($container->getParameter('mailing_connector.sendinblue.default') === true) {
            $defaultMailingConnector = new Definition(
                $container->getParameter('mailing_connector.manager.sendinblue.class'),
                array(
                    $container->getParameter('mailing_connector.sendinblue.api_key'),
                    $container->getParameter('mailing_connector.sendinblue.api_server')
                )
            );
        }

        /**
         * CampaignCommander API
         */
        if ($container->getParameter('mailing_connector.campaigncommander.default') === true) {
            $defaultMailingConnector = new Definition(
                $container->getParameter('mailing_connector.manager.campaigncommander.class'),
                array(
                    $container->getParameter('mailing_connector.campaigncommander.login'),
                    $container->getParameter('mailing_connector.campaigncommander.password'),
                    $container->getParameter('mailing_connector.campaigncommander.key'),
                    $container->getParameter('mailing_connector.campaigncommander.server')
                )
            );
        }

        if (null === $defaultMailingConnector) {
            throw new InvalidConfigurationException('You should set a default mailing connector.');
        }

        return $defaultMailingConnector;
    }
} 