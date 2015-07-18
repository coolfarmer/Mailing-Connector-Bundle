<?php

namespace coolfarmer\MailingConnectorBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MailingConnectorExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        /**
         * SendinBlue API
         */
        if (isset($config['sendinblue'])) {
            $requiredValues = array('api_key', 'api_server', 'default');
            foreach ($requiredValues as $value) {
                if (!isset($config['sendinblue'][$value])) {
                    throw new \InvalidArgumentException('Sendinblue "' . $value . '" option must be set');
                }

                $container->setParameter('mailing_connector.sendinblue.' . $value, $config['sendinblue'][$value]);
            }
        }

        /**
         * CampaignCommander API
         */
        if (isset($config['campaigncommander'])) {
            $requiredValues = array('login', 'password', 'key', 'server', 'default');
            foreach ($requiredValues as $value) {
                if (!isset($config['campaigncommander'][$value])) {
                    throw new \InvalidArgumentException('CampaignCommander "' . $value . '" option must be set');
                }

                $container->setParameter('mailing_connector.campaigncommander.' . $value, $config['campaigncommander'][$value]);
            }
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
