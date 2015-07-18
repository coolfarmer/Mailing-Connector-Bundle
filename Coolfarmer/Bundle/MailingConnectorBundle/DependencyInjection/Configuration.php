<?php

namespace coolfarmer\MailingConnectorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mailing_connector');
        $rootNode
            ->children()
                ->arrayNode('sendinblue')
                    ->children()
                        ->scalarNode('api_key')->end()
                        ->scalarNode('api_server')->end()
                        ->booleanNode('default')->end()
                    ->end()
                ->end()
            ->end()
        ;

        $rootNode
            ->children()
                ->arrayNode('campaigncommander')
                    ->children()
                        ->scalarNode('login')->end()
                        ->scalarNode('password')->end()
                        ->scalarNode('key')->end()
                        ->scalarNode('server')->end()
                        ->booleanNode('default')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
