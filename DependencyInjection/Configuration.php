<?php

namespace Hawkbox\Bundle\IronWorkerBundle\DependencyInjection;

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
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('iron_io')
            ->children()
                ->booleanNode('enabled')->isRequired()->end()

                ->scalarNode('token')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('project_id')->isRequired()->cannotBeEmpty()->end()

                ->arrayNode('api')
                    ->children()
                        ->scalarNode('protocol')->cannotBeEmpty()->end()
                        ->scalarNode('host')->cannotBeEmpty()->end()
                        ->scalarNode('port')->cannotBeEmpty()->end()
                        ->scalarNode('api_version')->cannotBeEmpty()->end()
                    ->end()
                ->end()

                ->arrayNode('options')
                    ->children()
                        ->scalarNode('max_retries')->cannotBeEmpty()->end()
                        ->booleanNode('debug_enabled')->end()
                        ->booleanNode('ssl_verifypeer')->end()
                        ->scalarNode('connection_timeout')->cannotBeEmpty()->end()
                    ->end()
                ->end()
            ->end();
        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
