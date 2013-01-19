<?php

namespace Hawkbox\Bundle\IronWorkerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class HawkboxIronWorkerExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        if ($config['enabled']) {
            // Required constructor args
            $options = array(
                'token'      => $config['token'],
                'project_id' => $config['project_id'],
            );

            // Copy optional constructor args from 'api' node
            if (isset($config['api'])) {
                $options = array_merge($options, $config['api']);
            }

            $definition = new Definition('IronMQ', array($options));

            // Set public properties from 'options' node
            if (isset($config['options'])) {
                foreach ($config['options'] as $key => $value) {
                    $definition->setProperty($key, $value);
                }
            }

            $container->setDefinition('code_meme_iron_mq.messagequeue', $definition);
        }
    }
}
